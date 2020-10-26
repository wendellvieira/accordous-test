
const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout'),
    children: [
		{ path: '', component: () => import('pages/Index') },

		{ path: 'contratos/novo', component: () => import('pages/NovoContratos') },
		{ path: 'imoveis', component: () => import('pages/Imoveis') },
		{ path: 'imoveis/novo', component: () => import('pages/NovoImovel') },
    ]
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '*',
    component: () => import('pages/Error404')
  }
]

export default routes
