import { mount } from 'vue-test-utils';
import Vue from 'vue';
import Alert from '../../resources/assets/js/components/Alert.vue';

function getRenderedText (Component, propsData) {
  const Constructor = Vue.extend(Component)
  const vm = new Constructor({ propsData: propsData }).$mount()
  return vm.$el.textContent
}

describe('Alert', () => {
  it('renders correctly with different props', () => {
    expect(getRenderedText(Alert, {
      message: 'Testando Alert'
    })).toBe('Testando Alert')

    expect(getRenderedText(Alert, {
      message: 'Testando Alert novamente'
    })).toBe('Testando Alert novamente')
  })
})
