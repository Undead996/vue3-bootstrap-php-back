(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-756aec5c"],{"0ceb":function(e,t,a){"use strict";var n=a("7a23"),c=["id"],o=["for"];function i(e,t,a,i,l,r){var s=this;return Object(n["openBlock"])(),Object(n["createElementBlock"])("div",{class:Object(n["normalizeClass"])(["form-check form-control-lg form-switch",this.type])},[Object(n["withDirectives"])(Object(n["createElementVNode"])("input",{class:"form-check-input",type:"checkbox",role:"switch",id:a.id,"onUpdate:modelValue":t[0]||(t[0]=function(e){return s.value=e}),onInput:t[1]||(t[1]=function(){return s.setValue&&s.setValue.apply(s,arguments)})},null,40,c),[[n["vModelCheckbox"],this.value]]),Object(n["createElementVNode"])("label",{class:"form-check-label",for:a.id},Object(n["toDisplayString"])(this.label?this.label:""),9,o)],2)}var l={data:function(){return{value:this.dataValue?this.dataValue:""}},props:{id:[String,Boolean],label:[String,Boolean],dataValue:[String,Boolean],type:{default:"form-switch-xl",type:[String]}},methods:{setValue:function(){this.value=!this.value,this.$emit("updateParentState",{id:this.id,value:this.value})}}},r=(a("3eef"),a("6b0d")),s=a.n(r);const d=s()(l,[["render",i]]);t["a"]=d},"1ce4":function(e,t,a){"use strict";a("2939")},2939:function(e,t,a){},"3eef":function(e,t,a){"use strict";a("f3bc")},5943:function(e,t,a){"use strict";var n=a("7a23"),c={class:"row container-fluid mt-1 g-3 p-0 align-items-center input"},o=["for"],i={key:0,class:"require"};function l(e,t,a,l,r,s){var d=Object(n["resolveComponent"])("SwitchSimple"),u=Object(n["resolveComponent"])("Popper");return Object(n["openBlock"])(),Object(n["createElementBlock"])("div",c,[Object(n["createElementVNode"])("div",{class:Object(n["normalizeClass"])(["col-sm-3 p-0",{"mt-0":this.first}])},[Object(n["createElementVNode"])("label",{for:a.id,class:"col-form-label input-label"},[Object(n["createTextVNode"])(Object(n["toDisplayString"])(this.label),1),this.require?(Object(n["openBlock"])(),Object(n["createElementBlock"])("span",i," *")):Object(n["createCommentVNode"])("",!0)],8,o)],2),Object(n["createElementVNode"])("div",{class:Object(n["normalizeClass"])(["col-sm-9 p-0 input-wrapper",{"mt-0":this.first}])},[Object(n["createVNode"])(d,{id:a.id,dataValue:this.dataValue,type:this.type,onUpdateParentState:this.setValue},null,8,["id","dataValue","type","onUpdateParentState"]),this.hint?(Object(n["openBlock"])(),Object(n["createBlock"])(u,{key:0,class:"bs-tooltip",content:this.hint},null,8,["content"])):Object(n["createCommentVNode"])("",!0)],2)])}var r=a("0ceb"),s=a("23ed"),d={components:{Popper:s["a"],SwitchSimple:r["a"]},data:function(){return{value:!!this.dataValue}},props:{id:[String,Boolean],label:[String],hint:[String],first:{type:Boolean,default:!1},type:{default:"form-switch-xl",type:[String]},require:[Boolean],dataValue:[String,Boolean]},methods:{setValue:function(e){this.$emit("updateParentState",{id:e.id,value:e.value})}}},u=(a("1ce4"),a("6b0d")),p=a.n(u);const b=p()(d,[["render",l],["__scopeId","data-v-22330d8e"]]);t["a"]=b},b756:function(e,t,a){"use strict";a.r(t);var n=a("7a23"),c={class:""},o=Object(n["createElementVNode"])("div",{class:"row container-fluid g-3 p-0"},[Object(n["createElementVNode"])("h5",null,"Волшебное слово - это дополнительная настройка безопасности."),Object(n["createElementVNode"])("h5",{class:"my-1"},"Если волшебное слово включено, то каждый раз при авторизации система будет просить вас ввести какие-то символы (по их порядковому номеру) из волшебного слова.")],-1),i={class:"content my-2 p-4"},l=Object(n["createElementVNode"])("div",{class:"row container-fluid mt-1 g-3 p-0"},[Object(n["createElementVNode"])("h3",null,"Спрашивать волшебное слово:")],-1),r={class:"content p-4"},s={class:"row container-fluid g-3 align-items-center justify-content-center input"},d={class:"col-sm-2"};function u(e,t,a,u,p,b){var m=Object(n["resolveComponent"])("Input"),h=Object(n["resolveComponent"])("Switch"),f=Object(n["resolveComponent"])("Button");return Object(n["openBlock"])(),Object(n["createElementBlock"])("div",c,[Object(n["createElementVNode"])("div",null,[o,Object(n["createElementVNode"])("div",i,[Object(n["createVNode"])(m,{type:"text",dataValue:this.data.magic_word,first:!0,label:"Волшебное слово:",require:!0,id:"magic_word",onUpdateParentState:this.updateState},null,8,["dataValue","onUpdateParentState"])]),l]),Object(n["createElementVNode"])("div",r,[Object(n["createVNode"])(h,{label:"При входе в кабинет:",first:!0,dataValue:this.data.antifishing_on,id:"on_enter",onUpdateParentState:this.updateState},null,8,["dataValue","onUpdateParentState"]),Object(n["createVNode"])(h,{label:"При оплате через мерчант:",id:"on_merchant",onUpdateParentState:this.updateState},null,8,["onUpdateParentState"]),Object(n["createVNode"])(h,{label:"При использовании карты:",id:"on_card",onUpdateParentState:this.updateState},null,8,["onUpdateParentState"])]),Object(n["createElementVNode"])("div",s,[Object(n["createElementVNode"])("div",d,[Object(n["createVNode"])(f,{name:"Сохранить",type:"btn-warning btn-lg",onClick:this.set_magic},null,8,["onClick"])])])])}var p=a("fada"),b=a("5943"),m=a("bab6"),h={components:{Input:p["a"],Button:m["a"],Switch:b["a"]},data:function(){return{data:{magic_word:"",on_card:!1,on_enter:!1,on_merchant:!1},ready:!1}},methods:{updateState:function(e){!1===e.value?e.value="0":!0===e.value&&(e.value="1"),this.data[e.id]=e.value,console.log(this.data)},set_magic:function(){this.axios.post("SetMagic",{data:this.data})},get_magic:function(){var e=this;this.axios.post("GetMagic").then((function(t){e.data=t.data.body}))}},created:function(){this.$store.commit("TITLE","Волшебное слово"),this.get_magic()}},f=a("6b0d"),j=a.n(f);const v=j()(h,[["render",u]]);t["default"]=v},f3bc:function(e,t,a){}}]);
//# sourceMappingURL=chunk-756aec5c.efe9a52c.js.map