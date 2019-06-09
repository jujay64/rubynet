
<template>
    <nav class="sticky-shrinknav-header">
      <h1 class="sticky-shrinknav-header-title">Rubynet</h1>
      <div class="right">
        <accountmenu></accountmenu>
      </div>
      <ul class="menu align-center sticky-shrinknav-menu">
        <li>
          <router-link :to="{ name: 'home'}">
            <span class="logo">Home</span>
          </router-link>  
        </li>   
        <li>
          <router-link :to="{ name: 'users' }">
              Browse people
          </router-link>
        </li>
        <li><a href="#">Blog</a></li>
        <li><a href="#">Gallery</a></li>
        <li><a href="#">About</a></li>
        </ul>     
    </nav>
</template>
<script>    
    import accountmenu from './Account';

    export default {
      components: {
        accountmenu
      },
      mounted(){
        $(function() {
          $(window).scroll(function() {
            var winTop = $(window).scrollTop();
            if (winTop >= 30) {
              $("body").addClass("sticky-shrinknav-wrapper");
            } 
            else{
              $("body").removeClass("sticky-shrinknav-wrapper");
            }
          });
        });
      }
    }  
</script>

