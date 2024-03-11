<script setup>
import { Link} from "@inertiajs/vue3";

defineProps({
   user: Object,
   current_project: Object,
   active_url: Object
});

let notify_header_rendered=null;
const renderNotify=()=>{
    fetch('/api/v1/notification')
   .then(response => response.json())
   .then(response => {
if(!notify_header_rendered){
    const noti_header=`<li class="li-header">
            <p class="f-w-700 mb-0">
            You have ${response.length} Notifications<span class="pull-right badge badge-primary badge-pill">${response.length}</span>
            </p>
        </li>`;
    document.querySelector('.notification-dropdown.onhover-show-div').insertAdjacentHTML('afterbegin',noti_header)
    notify_header_rendered=true;
}
       // document.querySelector('.notification-dropdown.onhover-show-div').innerHTML="";
    if(response.length==0){
        document.querySelector('.dot-animated').style="display:none";
    }else{
        document.querySelector('.dot-animated').style="display:inline";
    }
    for(let item of response){
        const notify_item=`
  <li class="noti-primary">
    <div class="media" id="notify-items">
             <div class="media-body">
                <p>${item.message}</p>
                <span>${item.created}</span>
         </div>
    </div>
</li>
      `;
        document.querySelector('.notification-dropdown.onhover-show-div').insertAdjacentHTML('beforeend',notify_item)
    }
   })
   .catch(err=>{
    console.log(err);
   })
}
setInterval(() => renderNotify(),10000);
renderNotify();
</script>

<template>
<div class="font-sans antialiased page-wrapper compact-wrapper" id="pageWrapper">
   <div class="page-main-header">
      <div class="main-header-right row m-0">
         <div class="main-header-left">
            <div class="logo-wrapper">
               <Link href="/">
               <img class="img-fluid" src="../../images/logo/logo.png" alt="" />
               </Link>
            </div>
            <div class="toggle-sidebar">
               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-align-center status_toggle middle" id="sidebar-toggle">
                  <line x1="18" y1="10" x2="6" y2="10"></line>
                  <line x1="21" y1="6" x2="3" y2="6"></line>
                  <line x1="21" y1="14" x2="3" y2="14"></line>
                  <line x1="18" y1="18" x2="6" y2="18"></line>
               </svg>
            </div>
         </div>

         <div class="left-menu-header col">
            <ul>
               <li>
                  <div class="dropdown select-main-project" v-if="user['projects'].length > 0">
                     <button class="btn btn-light" type="button" data-bs-toggle="dropdown">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box">
                           <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                           <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                           <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                        <template v-if="current_project != null">
                           {{ current_project["name"] }}
                        </template>
                        <template v-else>Выберите проект</template>
                     </button>
                     <ul class="dropdown-menu">
                        <li class="d-block" v-for="project in user['projects']">
                           <Link class="dropdown-item" :href="'/projects/' + project['id']">{{
                      project["name"]
                    }}</Link>
                        </li>
                     </ul>
                  </div>
               </li>
            </ul>
         </div>

         <div class="nav-right col pull-right right-menu p-0">
            <ul class="nav-menus">
               <li>
                  <a class="text-dark" href="#">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize">
                        <path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path>
                     </svg>
                  </a>
               </li>

               <li class="onhover-dropdown">
                  <div class="notification-box">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
                        <path d="M22 17H2a3 3 0 0 0 3-3V9a7 7 0 0 1 14 0v5a3 3 0 0 0 3 3zm-8.27 4a2 2 0 0 1-3.46 0"></path>
                     </svg>
                     <span style="display:none"  class="dot-animated"></span>
                  </div>
                  <ul class="notification-dropdown onhover-show-div" style="transition: all linear 0.3s !important;max-height:280px;overflow-y:auto"> </ul>
               </li>

               <li class="onhover-dropdown p-0">
                  <Link href="/logout" method="post" as="button" class="btn btn-primary-light" type="button">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out">
                     <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                     <polyline points="16 17 21 12 16 7"></polyline>
                     <line x1="21" y1="12" x2="9" y2="12"></line>
                  </svg>
                  Выйти из аккаунт
                  </Link>
               </li>
            </ul>
         </div>
         <div class="d-lg-none mobile-toggle pull-right w-auto">
            <i data-feather="more-horizontal"></i>
         </div>
      </div>
   </div>

   <div class="page-body-wrapper horizontal-menu">
      <header class="main-nav">
         <div class="sidebar-user text-center">
            <Link class="setting-primary" href="/profile">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings">
               <circle cx="12" cy="12" r="3"></circle>
               <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
            </svg>
            </Link>

            <img class="img-90 rounded-circle" v-if="user['avatar'] != null" :src="user['avatar']" alt="" />
            <img class="img-90 rounded-circle" v-else src="../../images/dashboard/1.png" alt="" />

            <div class="badge-bottom">
               <span class="badge badge-primary">{{ user["role"] }}</span>
            </div>

            <Link href="/profile">
            <h6 class="mt-3 f-14 f-w-600">{{ user["name"] }}</h6>
            </Link>
            <p class="mb-0 font-roboto">{{ user["email"] }}</p>

            <ul>
               <li>
                  <span>{{ user["projects_count"] }}</span>
                  <p>Проекты</p>
               </li>
               <li>
                  <span><span class="counter">{{ user["keywords"] }}</span></span>
                  <p>Запросы</p>
               </li>
               <li>
                  <span><span class="counter">{{ user["balance"] }}</span>$</span>
                  <p>Баланс</p>
               </li>
            </ul>
         </div>

         <nav>
            <div class="main-navbar">
               <div id="mainnav">
                  <ul class="nav-menu custom-scrollbar">
                     <li></li>
                     <template v-if="current_project != null">
                        <li class="dropdown mb-1">
                           <Link class="nav-link menu-title link-nav" v-bind:class="{ active: active_url === 'show' }" :href="'/projects/' + current_project['id']">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart">
                              <line x1="12" y1="20" x2="12" y2="10"></line>
                              <line x1="18" y1="20" x2="18" y2="4"></line>
                              <line x1="6" y1="20" x2="6" y2="16"></line>
                           </svg>
                           <span>Проверка позиций</span>
                           </Link>
                        </li>
                        <li class="dropdown mb-1" v-if="user['id'] === current_project['owner_id']">
                           <Link class="nav-link menu-title link-nav" v-bind:class="{ active: active_url === 'keywords' }" :href="'/projects/' + current_project['id'] + '/keywords'">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list">
                              <line x1="8" y1="6" x2="21" y2="6"></line>
                              <line x1="8" y1="12" x2="21" y2="12"></line>
                              <line x1="8" y1="18" x2="21" y2="18"></line>
                              <line x1="3" y1="6" x2="3.01" y2="6"></line>
                              <line x1="3" y1="12" x2="3.01" y2="12"></line>
                              <line x1="3" y1="18" x2="3.01" y2="18"></line>
                           </svg>
                           <span>Поисковые запросы</span>
                           </Link>
                        </li>
                        <li class="dropdown mb-1" v-if="user['id'] === current_project['owner_id']">
                           <Link class="nav-link menu-title link-nav" v-bind:class="{ active: active_url === 'import' }" :href="'/projects/' + current_project['id'] + '/import'">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-database">
                              <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                              <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                              <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
                           </svg>
                           <span>Импорт запросов</span>
                           </Link>
                        </li>
                        <li class="dropdown mb-1" v-if="user['id'] === current_project['owner_id']">
                           <Link class="nav-link menu-title link-nav" v-bind:class="{ active: active_url === 'tasks' }" :href="'/projects/' + current_project['id'] + '/tasks'">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-git-pull-request">
                              <circle cx="18" cy="18" r="3"></circle>
                              <circle cx="6" cy="6" r="3"></circle>
                              <path d="M13 6h3a2 2 0 0 1 2 2v7"></path>
                              <line x1="6" y1="9" x2="6" y2="21"></line>
                           </svg>
                           <span>Задачи</span>
                           </Link>
                        </li>
                        <li class="dropdown mb-1" v-if="user['id'] === current_project['owner_id']">
                           <Link class="nav-link menu-title link-nav" v-bind:class="{ active: active_url === 'edit' }" :href="'/projects/' + current_project['id'] + '/edit'">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sliders">
                              <line x1="4" y1="21" x2="4" y2="14"></line>
                              <line x1="4" y1="10" x2="4" y2="3"></line>
                              <line x1="12" y1="21" x2="12" y2="12"></line>
                              <line x1="12" y1="8" x2="12" y2="3"></line>
                              <line x1="20" y1="21" x2="20" y2="16"></line>
                              <line x1="20" y1="12" x2="20" y2="3"></line>
                              <line x1="1" y1="14" x2="7" y2="14"></line>
                              <line x1="9" y1="8" x2="15" y2="8"></line>
                              <line x1="17" y1="16" x2="23" y2="16"></line>
                           </svg>
                           <span>Настройки</span>
                           </Link>
                        </li>
                     </template>

                     <li></li>
                     <li class="dropdown mb-1" v-if="user['role'] === 'Admin'">
                        <Link class="nav-link menu-title link-nav" :class="{ active: $page.url.startsWith('/users') }" :href="'/users/'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                           <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                           <circle cx="9" cy="7" r="4"></circle>
                           <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                           <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <span>Пользователи</span>
                        </Link>
                     </li>
                  </ul>
               </div>
            </div>
         </nav>
      </header>

      <div class="page-body">
         <div class="container-fluid">
            <slot />
         </div>
      </div>

      <footer class="footer">
         <div class="container-fluid">
            <div class="row">
               <div class="col-md-6 footer-copyright">
                  <p class="mb-0">Copyright 2021-22 © Viho All rights reserved.</p>
               </div>
               <div class="col-md-6">
                  <p class="pull-right mb-0">Hand crafted & made with love</p>
               </div>
            </div>
         </div>
      </footer>
   </div>
</div>
</template>
