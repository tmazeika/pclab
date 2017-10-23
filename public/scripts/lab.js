Vue.component('lab-section', {
  template: '#lab-section-template',
  props: ['section'],
  data: function() {
    return {

    }
  }
});

Vue.component('tile', {
  template: '#tile-template',
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

const components = JSON.parse(document.getElementById('components').innerHTML);

const app = new Vue({
  el: 'body > main',
  data: {
    sections: [
      {
        name: 'Chassis',
        components: components.chassis
      }, {
        name: 'Processor',
        components: components.processors
      }, {
        name: 'Motherboard',
        components: components.motherboards
      }, {
        name: 'Graphics',
        components: components.graphics_cards
      }, {
        name: 'Memory',
        components: components.memory_sticks
      }, {
        name: 'Cooling',
        components: components.cooling_solutions
      }, {
        name: 'Storage',
        components: components.storage_devices
      }, {
        name: 'Power',
        components: components.power_supplies
      }
    ]
  }
});
