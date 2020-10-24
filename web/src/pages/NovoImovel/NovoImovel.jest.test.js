import { mount } from "@vue/test-utils"
import NovoImovel from "./index.vue"

describe("Teste de integração da página criar imovel", () => {
	let wrapper;

	beforeAll( () => {
		wrapper = mount( NovoImovel )
	})

	test("Teste", ()=> {
		expect( true ).toBe( false )
	})

})

