/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('NotFound', require('./components/404NotFound.vue').default);
//Vue Router//Vue Router//Vue Router
//Vue Router//Vue Router//Vue Router
import VueRouter from 'vue-router'
Vue.use(VueRouter)
let routes = [
    { path: '/dashboard', component:  require('./components/Dashboard.vue').default},
    { path: '/teachers', component:require('./components/Teachers.vue').default },
    { path: '/students', component:require('./components/Students.vue').default },
    { path: '/student-profile', component:require('./components/Students-Profile.vue').default },
    { path: '/teacher-profile', component:require('./components/Teachers-Profile.vue').default },
    { path: '/pending-requests', component:require('./components/Pending-Requests.vue').default },
    { path: '/documentsmanage', component:require('./components/DocumentsManage.vue').default },
    { path: '/documentsteacher', component:require('./components/DocumentsTeacher.vue').default },
    { path: '/singledoc', component:require('./components/singleDoc.vue').default }
  ]
  
let router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
  })

  //Vue V-form//Vue V-form//Vue V-form
  //Vue V-form//Vue V-form//Vue V-form
import { Form, HasError, AlertError } from 'vform'
window.Form=Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
//Vue Filter //Vue Filter //Vue Filter 
//Vue Filter //Vue Filter //Vue Filter 
Vue.filter('capitalize', function (value) {
  if (!value) return ''
  value = value.toString()
  return value.charAt(0).toUpperCase() + value.slice(1)
})
//Vue Progress bar//Vue Progress bar//Vue Progress bar
//Vue Progress bar//Vue Progress bar//Vue Progress bar
import VueProgressBar from 'vue-progressbar';

Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '3px'
});
//Sweet Alert//Sweet Alert//Sweet Alert
//Sweet Alert//Sweet Alert//Sweet Alert

import Swal from 'sweetalert2'
window.swal=Swal;
let Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  onOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})
window.toast=Toast;
//Vue Pdf
//import Pdf from 'vue-pdf';
//window.PDF=Pdf;
//Vue  //Vue   //Vue
//Vue  //Vue   //Vue
window.Fire=new Vue();
//Gate
import Gate from "./Gate";
Vue.prototype.$gate=new Gate(window.user);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


window.document_id='';
const app = new Vue({
    el: '#app',
    router
});

