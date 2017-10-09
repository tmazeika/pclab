// TODO: display AJAX's components

Vue.component('tile', {
  data: function() {
    return {
      active: false,
      brand: "Brand",
      name: "Name"
    };
  },
  methods: {
    select: function() {
      this.active = !this.active;
    }
  }
});

const app = new Vue({
  el: 'body > main',
  data: {
    sections: [
      'Chassis',
      'Processor',
      'Motherboard',
      'Graphics',
      'Memory',
      'Cooling',
      'Storage',
      'Power'
    ]
  }
});
