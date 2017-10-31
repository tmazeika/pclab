Vue.component('lab-section', {
  template: '#lab-section-template',
  props: ['section']
});

Vue.component('tile', {
  template: '#tile-template',
  props: ['component'],
  data: function() {
    return {
      active: false
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
  el: '#vue',
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
