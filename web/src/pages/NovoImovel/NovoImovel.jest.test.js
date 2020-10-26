import { shallowMount, createLocalVue } from "@vue/test-utils"

import Vuex from "vuex"
import Store from "src/store"

import NovoImovel from "./index.vue"

const localVue = createLocalVue()
localVue.use(Vuex)

describe("Teste de integração da página criar imovel", () => {


	test("Varificando a integridade da api de cep", async ()=> {
		const store = Store()
		const wrapper = shallowMount( NovoImovel, { store, localVue } )

		let inputCep = wrapper.find("input[name='cep']")

		console.log( inputCep )
		// inputCep.setValue("27240440")

		// expect( inputCep.text() ).toBe("27240-440")

		// await wrapper.vm.$nextTick()

		// console.log( wrapper.find("input[name='cidade']") )



	})

})

