<template>
  <div>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <router-link class="navbar-brand" :to="{ name: 'exam' }">Exam Appetiser</router-link>

        <button
          class="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <router-link class="nav-link" :to="{ name: 'exam' }">Home</router-link>
            </li>
          </ul>

          <ul class="navbar-nav ml-auto"></ul>
        </div>
    </nav>

    <div class="py-4">
      <router-view></router-view>
    </div>
  </div>
</template>
<script>
export default {};
</script>