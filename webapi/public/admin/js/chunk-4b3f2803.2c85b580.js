(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-4b3f2803"],{"39e0":function(e,t,n){"use strict";var a=n("a0c9"),l=n.n(a);l.a},"8db2":function(e,t){e.exports={props:{id:{type:String,required:!0},name:{type:String,required:!0},value:{type:null,default:null},type:{type:String,required:!0},length:{type:[String,Number],default:null},readonly:{type:Boolean,default:!1},required:{type:Boolean,default:!1},options:{type:Object,default:()=>({})},newItem:{type:Boolean,default:!1},relation:{type:Object,default:null},fields:{type:Object,default:null},values:{type:Object,default:null}}}},"91e0":function(e,t,n){"use strict";n.r(t);var a=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"buttons no-wrap"},e._l(e.displayValue,function(t,a){return n("span",{key:a},[e._v(e._s(t))])}),0)},l=[],u=(n("28a5"),n("8db2")),i=n.n(u),r={mixins:[i.a],computed:{displayValue:function(){var e=this;if(!this.value)return"";var t="array"===this.type?this.value:this.value.split(",");return this.options.wrap&&(t.pop(),t.shift()),this.options.format&&(t=t.map(function(t){return e.$helpers.formatTitle(t)})),t}}},p=r,s=(n("39e0"),n("2877")),o=Object(s["a"])(p,a,l,!1,null,"6c8fd406",null);t["default"]=o.exports},a0c9:function(e,t,n){}}]);
//# sourceMappingURL=chunk-4b3f2803.2c85b580.js.map