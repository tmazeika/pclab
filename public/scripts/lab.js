Vue.component('chassis-tile', {
  data: function() {
    return {
      active: false
    }
  },
  methods: {
    select: function() {
      this.active = !this.active;
    }
  }
}) ;

const app = new Vue({
  el: '.main'
});
