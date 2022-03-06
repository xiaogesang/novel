<template>
	<view
		class="mzy-tabs"
		:style="{
			height:height + 'px'
		}"
	>
		<scroll-view
			scroll-x
			class="mt__main"
			:scroll-left="scrollLeft"
			scroll-with-animation
			scroll-anchoring
			enhanced
			:show-scrollbar="false"
			:style="{
				background,
				height:height + 'px'
			}"
		>
			<!--居中-->
			<view v-if="center" class="mm__center__tab mt__row__center">
				<view
					v-for="(tab,index) in tabList"
					:key="index"
					:style="{
						margin:`0 ${gutter}px`
					}"
					class="mct__item mt__row__center"
					@tap="handleChange(index,tab)"
				>
					<text
						class="mzy__tab"
						:style="{
							'font-size':fontSize + 'px',
							color:current == index ? (activeColor || color) : color
						}"
					>
						{{tab.label}}
					</text>
				</view>
			</view>
			<!--等宽铺满-->
			<view v-else-if="grow" class="mm__grow__tab">
				<view
					v-for="(tab,index) in tabList"
					:key="index"
					class="mgt__item mt__row__center"
					:class="{ mzy__tab:sInfo.width != 'auto' }"
					@tap="handleChange(index,tab)"
				>
					<text
						:class="{
							mzy__tab:sInfo.width === 'auto'
						}"
						:style="{
							'font-size':fontSize + 'px',
							color:current == index ? (activeColor || color) : color }
						"
					>
						{{tab.label}}
					</text>
				</view>
			</view>
			<!--可滑动-->
			<block v-else>
				<view
					v-for="(tab,index) in tabList"
					:key="index"
					:style="{
						margin:`0 ${index + 1 == tabList.length ? paddingX || gutter :gutter}px 0 ${index == 0 ? paddingX || gutter :gutter}px`,
						'line-height':height + 'px'
					}"
					class="mm__tab mzy__tab"
					@tap="handleChange(index,tab)"
				>
					<text
						:style="{
							'font-size':fontSize + 'px',
							color:current == index ? (activeColor || color) : color
						}"
					>
						{{tab.label}}
					</text>
				</view>
			</block>
			<!--滑块（小程序被scroll-view组件包裹里面的标签bottom不正确，top却是正确的）-->
			<view
				v-if="animation"
				class="mm__slider"
				:style="{
					transition:`left ${animation ? sInfo.speed : 0}s linear`,
					width:sliderWidth + 'px',
					left:sliderX + 'px',
					top:height - sInfo.bottom - sInfo.height + 'px',
					height:sInfo.height + 'px',
					background:sInfo.color || activeColor || color,
					'border-radius':sInfo.round ? '100px' : 'unset'
				}"
			>
			</view>
			<!-- <view
				v-if="animation"
				class="mm__slider"
				:style="{
					transition:`transform ${animation ? sInfo.speed : 0}s linear`,
					width:sliderWidth + 'px',
					transform:`translateX(${sliderX}px)`,
					left:'0px',
					'will-change':'transform',
					top:height - sInfo.bottom - sInfo.height + 'px',
					height:sInfo.height + 'px',
					background:sInfo.color || activeColor || color,
					'border-radius':sInfo.round ? '100px' : 'unset'
				}"
			>
			</view> -->
		</scroll-view>
	</view>
</template>

<script>
	export default {
		props:{
			/**
			 * 1.数组格式可以是对象数组，对象数组需要设置listKey
			 * 2.也可以是普通数组[xxx,xxx,xx,...]
			 */
			list:{
				type:Array,
				default:() => []
			},
			color:{
				type:String,
				default:() => '#333'
			},
			activeColor:{
				type:String,
				default:() => ''
			},
			// 整体高度
			height:{
				type:Number | String,
				default:() => 40
			},
			slider:{
				type:Object,
				default:() => {}
			},
			// 如果传入的是数组，对应展示的字段名称
			listKey:{
				type:String,
				default:() => 'label'
			},
			// 整体的背景样式
			background:{
				type:String,
				default:() => ''
			},
			// 每个tab的水平外边距
			gutter:{
				type:Number | String,
				default:() => 8
			},
			// 是否平均分配，开启后会取消滑动功能
			grow:{
				type:Boolean,
				default:() => false
			},
			// 是否居中
			center:{
				type:Boolean,
				default:() => false
			},
			fontSize:{
				type:Number | String,
				default:() => 14
			},
			value:{
				type:Number | String,
				default:() => 0
			},
			// 左右间隔
			paddingX:{
				type:Number | String,
				default:() => 0
			}
		},
		data() {
			return {
				tabList:[],
				animation:false,
				windowWidth:0,
				scrollLeft:0,
				sInfo:{
					bottom:2,
					width:20, // 数值、'auto'或者'grow'
					height:4,
					speed:0.2,
					round:true
				},
				current:0
			};
		},
		computed:{
			sliderX(){
				const tab = this.tabList[this.current]
				if(tab && tab.info){
					return tab.info.left + tab.info.width / 2 - this.sliderWidth / 2
				}
				return 0
			},
			sliderWidth(){
				const sliderWidth = this.sInfo.width
				if(['auto','grow'].includes(sliderWidth)){
					const tab = this.tabList[this.current]
					if(tab && tab.info){
						return tab.info.width
					}
					return 0
				}else{
					return sliderWidth
				}
			}
		},
		created() {
			const	tabList = []
			this.list.forEach(item => {
				if(Object.prototype.toString.call(item) === '[object Object]'){
					tabList.push({
						...item,
						label:item[this.listKey]
					})
				}else{
					tabList.push({
						label:item
					})
				}
			})
			this.tabList = tabList
			this.windowWidth = uni.getSystemInfoSync().windowWidth
			this.sInfo = { ...this.sInfo,...this.slider }
		},
		watch:{
			value:{
				handler(val){
					const index = +val || 0
					this.current = index
					this.scrollLeft = this.sliderX + this.sliderWidth / 2 - this.windowWidth / 2
					this.$emit('change',index,this.list[index])
				}
			},
			immediate:true
		},
		mounted() {
			// this.current = +this.value
			this.$nextTick(() => {
				const query = uni.createSelectorQuery().in(this);
				query.selectAll('.mzy__tab').fields({
					rect:true,
					size:true
				},data => {
					data.forEach((node,index) => {
						this.$set(this.tabList[index],'info',node)
						// console.log(node)
					})
					this.scrollLeft = this.sliderX + this.sliderWidth / 2 - this.windowWidth / 2
					this.animation = true
				}).exec();
			})
		},
		methods:{
			handleChange(index,tab){
				// this.current = index
				// this.scrollLeft = this.sliderX + this.sliderWidth / 2 - this.windowWidth / 2
				this.$emit('input',index)
				// this.$emit('change',index,this.list[index])
			}
		}
	}
</script>

<style lang="scss" scoped>
.mzy-tabs{
	.mt__row__center{
		display: flex;
		align-items: center;
		justify-content: center;
	}
	.mt__main{
		overflow: auto;
		width: 100%;
		white-space: nowrap;
		position: relative;
		&::-webkit-scrollbar{
			display: none;
		}
		.mm__tab{
			display: inline-block;
		}
		.mm__slider{
			position: absolute;
			will-change: transform;
		}
		.mm__grow__tab{
			display: flex;
			height: 100%;
			align-items: center;
			.mgt__item{
				flex: 1;
				height: 100%;
			}
		}
		.mm__center__tab{
			height: 100%;
			.mct__item{
				height: 100%;
			}
		}
	}
}
</style>
