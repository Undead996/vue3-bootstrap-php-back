(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-7b3395cc"],{"0ceb":function(t,e,a){"use strict";var n=a("7a23"),i=["id"],o=["for"];function c(t,e,a,c,s,l){var r=this;return Object(n["openBlock"])(),Object(n["createElementBlock"])("div",{class:Object(n["normalizeClass"])(["form-check form-control-lg form-switch",this.type])},[Object(n["withDirectives"])(Object(n["createElementVNode"])("input",{class:"form-check-input",type:"checkbox",role:"switch",id:a.id,"onUpdate:modelValue":e[0]||(e[0]=function(t){return r.value=t}),onInput:e[1]||(e[1]=function(){return r.setValue&&r.setValue.apply(r,arguments)})},null,40,i),[[n["vModelCheckbox"],this.value]]),Object(n["createElementVNode"])("label",{class:"form-check-label",for:a.id},Object(n["toDisplayString"])(this.label?this.label:""),9,o)],2)}var s={data:function(){return{value:this.dataValue?this.dataValue:""}},props:{id:[String,Boolean],label:[String,Boolean],dataValue:[String,Boolean],type:{default:"form-switch-xl",type:[String]}},methods:{setValue:function(){this.value=!this.value,this.$emit("updateParentState",{id:this.id,value:this.value})}}},l=(a("3eef"),a("6b0d")),r=a.n(l);const d=r()(s,[["render",c]]);e["a"]=d},"1ce4":function(t,e,a){"use strict";a("2939")},2939:function(t,e,a){},"3de2":function(t,e,a){"use strict";a.r(e);var n=a("7a23"),i={class:""},o=Object(n["createElementVNode"])("div",{class:"row container-fluid g-3 p-0"},[Object(n["createElementVNode"])("h5",null,"Настройка антифишинга является дополнительным механизмом защиты при работе с кабинетом."),Object(n["createElementVNode"])("h5",{class:"my-1"},"Заданная вами приветственная фраза будет отображаться в верхней части любой страницы кабинета."),Object(n["createElementVNode"])("h5",{class:"pb-3 my-1"},"Правильная фраза покажет вам, что вы находитесь на правильном сайте, неверная фраза явится сигналом: не осуществляя операций, необходимо срочно связаться со службой безопасности нашей системы.")],-1),c={class:"content p-4"},s={class:"row container-fluid g-3 align-items-center justify-content-center input"},l={class:"col-sm-2"};function r(t,e,a,r,d,u){var h=Object(n["resolveComponent"])("Switch"),p=Object(n["resolveComponent"])("Input"),b=Object(n["resolveComponent"])("Button");return Object(n["openBlock"])(),Object(n["createElementBlock"])("div",i,[o,Object(n["createElementVNode"])("div",c,[Object(n["createVNode"])(h,{label:"Включить антифишинг:",dataValue:this.data.antifishing_on,first:!0,id:"antifishing_on",onUpdateParentState:this.updateState},null,8,["dataValue","onUpdateParentState"]),Object(n["createVNode"])(p,{type:"text",dataValue:this.data.string,label:"Строка антифишинга:",disabled:!this.data.antifishing_on,require:!0,id:"string",onUpdateParentState:this.updateState},null,8,["dataValue","disabled","onUpdateParentState"])]),Object(n["createElementVNode"])("div",s,[Object(n["createElementVNode"])("div",l,[Object(n["createVNode"])(b,{name:"Сохранить",type:"btn-warning btn-lg",onClick:this.set_antifishing},null,8,["onClick"])])])])}var d=a("fada"),u=a("5943"),h=a("bab6"),p={components:{Input:d["a"],Button:h["a"],Switch:u["a"]},data:function(){return{data:{antifishing_on:!!this.$store.state.userData.antiphishing,string:this.$store.state.userData.antiphishing},ready:!1}},methods:{updateState:function(t){this.data[t.id]=t.value},set_antifishing:function(){var t=this;this.data.antifishing_on?this.data.antifishing_on="1":this.data.antifishing_on="0",this.axios.post("SetAntifishing",{data:this.data}).then((function(e){"0"==e.data.body.result&&t.$store.dispatch("logout",t.$router)}))}},created:function(){this.$store.commit("TITLE","Антифишинг")}},b=a("6b0d"),f=a.n(b);const m=f()(p,[["render",r]]);e["default"]=m},"3eef":function(t,e,a){"use strict";a("f3bc")},5943:function(t,e,a){"use strict";var n=a("7a23"),i={class:"row container-fluid mt-1 g-3 p-0 align-items-center input"},o=["for"],c={key:0,class:"require"};function s(t,e,a,s,l,r){var d=Object(n["resolveComponent"])("SwitchSimple"),u=Object(n["resolveComponent"])("Popper");return Object(n["openBlock"])(),Object(n["createElementBlock"])("div",i,[Object(n["createElementVNode"])("div",{class:Object(n["normalizeClass"])(["col-sm-3 p-0",{"mt-0":this.first}])},[Object(n["createElementVNode"])("label",{for:a.id,class:"col-form-label input-label"},[Object(n["createTextVNode"])(Object(n["toDisplayString"])(this.label),1),this.require?(Object(n["openBlock"])(),Object(n["createElementBlock"])("span",c," *")):Object(n["createCommentVNode"])("",!0)],8,o)],2),Object(n["createElementVNode"])("div",{class:Object(n["normalizeClass"])(["col-sm-9 p-0 input-wrapper",{"mt-0":this.first}])},[Object(n["createVNode"])(d,{id:a.id,dataValue:this.dataValue,type:this.type,onUpdateParentState:this.setValue},null,8,["id","dataValue","type","onUpdateParentState"]),this.hint?(Object(n["openBlock"])(),Object(n["createBlock"])(u,{key:0,class:"bs-tooltip",content:this.hint},null,8,["content"])):Object(n["createCommentVNode"])("",!0)],2)])}var l=a("0ceb"),r=a("23ed"),d={components:{Popper:r["a"],SwitchSimple:l["a"]},data:function(){return{value:!!this.dataValue}},props:{id:[String,Boolean],label:[String],hint:[String],first:{type:Boolean,default:!1},type:{default:"form-switch-xl",type:[String]},require:[Boolean],dataValue:[String,Boolean]},methods:{setValue:function(t){this.$emit("updateParentState",{id:t.id,value:t.value})}}},u=(a("1ce4"),a("6b0d")),h=a.n(u);const p=h()(d,[["render",s],["__scopeId","data-v-22330d8e"]]);e["a"]=p},f3bc:function(t,e,a){}}]);
//# sourceMappingURL=chunk-7b3395cc.84d21430.js.map