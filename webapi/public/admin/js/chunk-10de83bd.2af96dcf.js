(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-10de83bd"],{"26b2":function(e,t,n){"use strict";n.r(t);var l=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("v-input",{attrs:{type:"text","icon-right-color":"",value:e.value||"",readonly:e.readonly,placeholder:e.options.placeholder,"icon-left":e.options.iconLeft,"icon-right":e.options.iconRight,maxlength:e.length?+e.length:null,id:e.name,charactercount:e.options.showCharacterCount},on:{input:e.updateValue}})},u=[],i=n("8db2"),o=n.n(i),a={mixins:[o.a],methods:{updateValue:function(e){var t=e;this.options.trim&&(!this.value||t.length>this.value.length)&&(t=t.trim()),this.$emit("input",t)}}},r=a,p=(n("6420"),n("2877")),d=Object(p["a"])(r,l,u,!1,null,"5b54d147",null);t["default"]=d.exports},6420:function(e,t,n){"use strict";var l=n("9048"),u=n.n(l);u.a},"8db2":function(e,t){e.exports={props:{id:{type:String,required:!0},name:{type:String,required:!0},value:{type:null,default:null},type:{type:String,required:!0},length:{type:[String,Number],default:null},readonly:{type:Boolean,default:!1},required:{type:Boolean,default:!1},options:{type:Object,default:()=>({})},newItem:{type:Boolean,default:!1},relation:{type:Object,default:null},fields:{type:Object,default:null},values:{type:Object,default:null}}}},9048:function(e,t,n){}}]);
//# sourceMappingURL=chunk-10de83bd.2af96dcf.js.map