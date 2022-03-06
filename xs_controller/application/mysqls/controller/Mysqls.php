<?php

namespace app\mysqls\controller;

use think\Db;
use ROOT_PATH\admin\sql;
use think\Controller;

class Mysqls extends Controller {
    public function Index() { //根据数据库 生成文件
        $admin = scandir("admin");
        if (!in_array('sql',$admin)) {
            $dir = iconv("UTF-8", "GBK", "admin/sql");
            mkdir ($dir,0777,true);
        }
        $tables = Db::query("show tables"); //获取所有的数据表。
        foreach ($tables as $key => $val) {
            $val = end($val); //整理出表名
            $tableName = $val;
            $res = Db::query("SHOW FULL COLUMNS FROM $tableName"); //根据表名查询表结构
            $temp = ''; //声明一个临时变量。
            foreach ($res as $k => $v) {
                foreach ($v as $kk => $vv) {
                    if (!$vv) {
                        $vv = NULL;
                    }
                    if ($kk == 'Comment') {
                        if ($k != count($res) - 1) {
                            $vv = $vv . '|';
                        }
                    } else {
                        $vv = $vv . '/';
                    }

                    $temp .= "" . $kk . "=>" . $vv;
                }
            } //字符处理，方便读取时进行数据转换。
            $strStart = "";
            $return = "";
            $strEnd = $return;
            $strStart .= $temp;
            $strStart .= $strEnd;
            $strName = 'admin/sql/' . $val . 'Sql.php'; //生成文件名称
            $fp = fopen($strName, "w"); //打开文件
            fwrite($fp, $strStart); //写入内容
            fclose($fp); //保存并关闭文件。
        }
        echo "生成成功！";
        die;
    }

    public function readPhp() {
        $allTables = scandir("admin/sql/"); //进入目录并获取到当前所有的文件
        $tables = []; //声明一个空数组，这个数组用来装处理后的所有表的表名。
        foreach ($allTables as $key => $value) { //删除数组内上一级和顶级，因此这两个目录不是sql同步文件
            if ($value != '.' && $value != '..') {
                $value = substr($value, 0, strpos($value, '.'));
                $tables[] = $value;
            }
        }
        $dbContent = []; //声明一个空数组，这个数组用来装一个表的表结构
        $db = []; //声明一个空数组，这个空数组用来装所有的表的表结构
        foreach ($tables as $key => $value) {
            $tableName = $value;
            $file_path = "admin/sql/" . $tableName . ".php"; //生成文件名称
            if (file_exists($file_path)) { //检查文件是否存在。
                $fp = fopen($file_path, "r"); //以只读方式打开文件
                $str = fread($fp, filesize($file_path));//指定读取大小，这里把整个文件内容读取出来
                $array = $str; //以下遍历作为将字符转化为数组的处理。
                $array = explode('|', $array);
                foreach ($array as $key => $value) {
                    $value = explode('/', $value);
                    foreach ($value as $k => $v) {
                        $v = explode("=>", $v);
                        $value[$k] = $v;
                    }
                    $array[$key] = $value;
                }
                $dbContent = [];
                foreach ($array as $key => $val) {
                    $temp = [];
                    foreach ($val as $k => $value) {
                        $temp[$value[0]] = $value[1];
                    }
                    $dbContent[] = $temp;
                }
            }
            // dump($value);die;
            $db[$tableName] = $dbContent;
            //此处$dbContent与SHOW FULL COLUMNS FROM $tableName的结果一致，此时只要对比所有的结构就可以判断出是否是一致；
        }
        //此处$db即本地SQl的文件内容。此时，应读取本地数据库做对比。
        dump($db);
        die;
    }

    public function updateDb() { //以本地文件为依据，更新数据表
        $admin = scandir("admin");
        if (!in_array('sql',$admin)) {
            $dir = iconv("UTF-8", "GBK", "admin/sql");
            mkdir ($dir,0777,true);
        }
        $allTables = scandir("admin/sql/");
        $tables = []; //为了正确使用变量，应先进行变量声明。
        foreach ($allTables as $key => $value) { //此处将所有的文件名称读取出来，并合并成为一个数组$tables。
            if ($value != '.' && $value != '..') {
                $value = substr($value, 0, strpos($value, '.'));
                $value = substr($value, 0, strpos($value, 'Sql'));
                $tables[] = $value;
            }
        }
        $db = [];
        $dbContent = [];
        foreach ($tables as $key => $value) {
            $tableName = $value;
            $file_path = "admin/sql/" . $tableName . "Sql.php";
            if (file_exists($file_path)) {
                $fp = fopen($file_path, "r");
                $str = fread($fp, filesize($file_path));//指定读取大小，这里把整个文件内容读取出来
                $array = $str;
                $array = explode('|', $array);
                foreach ($array as $key => $value) {
                    $value = explode('/', $value);
                    foreach ($value as $k => $v) {
                        $v = explode("=>", $v);
                        if (strlen($v[1])==0 && $v[0]!='Comment') {
                            $v[1] = NULL;
                        }
                        $value[$k] = $v;
                    }
                    $array[$key] = $value;
                }
                $dbContent = [];
                foreach ($array as $key => $val) {
                    $temp = [];
                    foreach ($val as $k => $value) {
                        $temp[$value[0]] = $value[1];
                    }
                    $dbContent[] = $temp;//此处$dbContent与SHOW FULL COLUMNS FROM $tableName的结果一致，此时只要对比所有的结构就可以判断出是否是一致；
                }
            }
            $db[$tableName] = $dbContent;//此处生成的$db是一个三维数组，其中，第一层结果代表了各个数据表，第二层代表了各个数据表的结构，第三层代表了各个数据表结构的值
        }
        //得出存储在本地的各个数据表结构后，开始读取本地数据库的数据结构
        $temp = Db::query("show tables");//此处获取到了所有的数据表
        $WebTables = [];
        foreach ($temp as $key=>$val){
            $WebTables[] = end($val);
        }
        //此处$tables即读取到的本地的表名。$WebTables为数据库的表名
        $template = [];
        foreach ($WebTables as $key=>$val){
            $template[] = $val;
        }

        $LocalDb = [];
        foreach ($WebTables as $key => $val) {
            $a = Db::query('SHOW FULL COLUMNS FROM '.$val);
            $LocalDb[$val] = $a;
        }
        //此处template是添加后缀名称后的数据
        $newDb = '';
        $newDbContent = '';
        if (count($template) < count($tables)){ 
        //如果本地的表比数据库的表多，那么就代表着要新建数据表。由于本方法以本地文件为依据，更新数据表为目的，因此，应先筛选出新增的数据表，然后查询出新增的数据表的结构。
        //示例SQL语句：CREATE TABLE testSql ( id int(11) auto_increment PRIMARY key NOT NULL,user_name varchar(255) ,password varchar(255),full_name varchar(255),add_time datetime,status smallint(6) UNSIGNED);
            $newDb=array_merge(array_diff($tables,$WebTables),array_diff($WebTables,$tables));
            foreach ($newDb as $key => $value) { //$value是表名
                $sql = '';
                $newDbContent = $db[$value];
                $Start = 'CREATE TABLE '.$value.' ( ';
                foreach ($newDbContent as $k => $v) {
                    $sql .= $v['Field'].' '.$v['Type'];
                    if ($v['Extra'] == 'auto_increment'){
                        $sql = $sql.' auto_increment PRIMARY key';
                    }
                    if ($v['Key'] == 'PRI'){
                        $sql = $sql.' NOT NULL';
                    }
                    if ($v['Null'] == 'YES'){
                        $sql = $sql.' NULL';
                    }
                    if ($k!= count($newDbContent)-1 ) {
                        $sql .= ' ,';
                    }
                }
                $End = '  )';
                $sql = $Start.$sql.$End;
                $ref = Db::query($sql);//执行新增数据表完成。
            }
        }//新增数据表的if函数结束。

        //在数据表数量一致或本地所需要有的数据表都存在后，开始比对数据表内结构。
        //此处开始更改表结构，首先查询是否存在新增字段，如果有，那就新增字段下去。
        //更改表结构示例：alter table admin change user_name user_name varchar(255) not null;
        //当本地数据表的数量小于或等于数据库的数据表的时候。此时，我们可以直接忽略这部分。我们需要考虑到以下部分：
            // 1、字段内的字段类型有修改。
            // 2、字段新增
            // 3、字段删除。
            // 如何完成以下事件：字段比对。
            // $db是本地文件生成的数据表结构，$LocalDb是根据数据库生成的表结构数组。
        $MyDbNames = [];//存放本地文件的表及字段名称的变量
        $MyDbCount = [];
        foreach ($db as $key => $val) {
            foreach ($val as $k => $v) {
                $MyDbNames[$key][] = $v['Field'];

            }
            $MyDbCount[$key][] = count($val);
        }

        $LocalNames = [];//存放数据库文件的表及字段名称的变量
        $LocalCount = [];

        $temp = Db::query("show tables");//此处获取到了所有的数据表
        $WebTables = [];
        foreach ($temp as $key=>$val){
            $WebTables[] = end($val);
        }
        
        $LocalDb = [];
        foreach ($WebTables as $key => $val) {
            $a = Db::query('SHOW FULL COLUMNS FROM '.$val);
            $LocalDb[$val] = $a;
        }
        foreach ($LocalDb as $key => $val) {
            foreach ($val as $k => $v) {
                $LocalNames[$key][] = $v['Field'];
            }
            $LocalCount[$key][] = count($val);
        }

        $NeedAdd = [];//存放新增的表及字段名称的变量
        // dump($LocalNames);die;
        foreach ($MyDbNames as $key => $val) {
            if ($LocalNames[$key]) {
            $checkDb = $LocalNames[$key];
            foreach ($val as $k => $v) {
                if (!in_array($v, $checkDb)) {
                    $NeedAdd[$key][] = $v;
                }
            }
            }
        }

        if (count($NeedAdd)>0 && $LocalCount!=$MyDbCount) { //如果存在新增字段
            foreach ($NeedAdd as $key => $val) {
                $tempVal = $db[$key];
                foreach($val as $kk => $vv){
                    foreach ($tempVal as $k => $v) {
                        if ($vv == $v['Field']) {
                            $addSql = '';
                            $addSql = 'alter table '.$key.' add '.$vv;
                            $addSql .= ' '.$v['Type'];
                            if ($v['Null'] != 'YES') {
                                $nulls = ' NOT NULL';
                            }
                            else{
                                $nulls = ' NULL';
                            }
                            $addSql .= $nulls;
                            // dump($addSql);die;
                            Db::query($addSql);
                        }
                    }
                }       
            }
        }
        if (count($NeedAdd)>0 && $LocalCount == $MyDbCount ) { //如果字段改名
            $changeName = [];
            $OldName = [];
            foreach ($MyDbNames as $key => $val) {
                $tempVal = '';
                $tempLocalVal = '';
                $tempVal = $val;

                if ($tempVal != $LocalNames[$key]) {
                    $tempLocalVal = $LocalNames[$key];
                    foreach ($tempVal as $kt => $vt) {  
                        if (!in_array($vt, $tempLocalVal)) { //此处已查找出该字段
                            $changeName[$key][] = $vt;
                            $OldName[$key][] = $tempLocalVal[$kt];
                        }
                    }
                }
            }
            //alter table test change t_name t_name_new varchar(20);
            foreach ($changeName as $key => $val) {
                $tempVal = $db[$key];
                $oldVal = $OldName[$key];
                foreach ($val as $k => $v) { 
                    foreach ($tempVal as $kk => $vv) {
                        if ($v == $vv['Field']) {
                                $reNameSql = '';
                                $reNameSql = 'alter table '.$key.' change ';
                                $oldname = $oldVal[$k];
                                $reNameSql = $reNameSql.$oldname;
                                $reNameSql .= ' '.$v.' '.$vv['Type'];
                                if ($vv['Null'] == 'YES') {
                                    $reNameSql .= ' NULL';
                                }
                                else{
                                    $reNameSql .= ' NOT NULL';
                                }
                                Db::query($reNameSql);
                           }   
                    }
                }
            }
        }

        if (count($NeedAdd) <1 && $LocalCount == $MyDbCount ) { //如果存在改编字段结构
            //alter table img change src src varchar (25) NOT NULL;
            $changeAllType = '';
            $tempTable = [];
            foreach ($db as $key => $val) {
                $tempTable = $db[$key];
                foreach ($tempTable as $k => $v) {
                    if ($v['Field'] != 'id'&&$v['Field'] != 'Id') {                        
                        $tempSql = '';
                        $tempName = $v['Field'];
                        $tempType = $v['Type'];
                        $tempSql = 'alter table '.$key.' change '.$tempName.' '.$tempName.' '.$tempType;
                        if ($v['Extra']!=NULL) {
                            $tempExtra = $v['Extra'];
                            if ($v['Extra'] == 'auto_increment') {
                                $tempSql .='  auto_increment PRIMARY key';
                            }
                        }
                        if ($v['Null'] == 'YES') {
                            $tempNull = ' NULL';
                        }
                        else{
                            $tempNull = ' NOT NULL';
                        }
                        $tempSql .= $tempNull;
                        Db::query($tempSql);
                    }   
                }
            }
        }
        echo "更新结束";
        die;        
    }
}
