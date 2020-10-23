import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

import MAIN_LAYOUT from "layouts/MainLayout/state"

export default function () {
  const Store = new Vuex.Store({
    modules: {
		MAIN_LAYOUT
    },
    strict: process.env.DEBUGGING
  })

  return Store
}
