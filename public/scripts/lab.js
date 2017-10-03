const tileComponent = {
  data: function() {
    return {
      active: false,
      hovering: false
    }
  },
  methods: {
    select: function() {
      this.active = !this.active;
    }
  }
};

Vue.component('chassis-tile', tileComponent);
Vue.component('processor-tile', tileComponent);
Vue.component('motherboard-tile', tileComponent);
Vue.component('graphics-card-tile', tileComponent);
Vue.component('memory-stick-tile', tileComponent);
Vue.component('cooling-solution-tile', tileComponent);
Vue.component('storage-device-tile', tileComponent);
Vue.component('power-supply-tile', tileComponent);

const app = new Vue({
  el: '.main'
});
