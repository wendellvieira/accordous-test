
const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
		{ path: '', component: () => import('pages/Index.vue') },

		{ path: 'contratos', component: () => import('pages/Contratos') },
		{ path: 'contratos/novo', component: () => import('pages/NovoContrato') },
		{ path: 'imoveis', component: () => import('pages/Imoveis') },
    ]
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '*',
    component: () => import('pages/Error404.vue')
  }
]

export default routes
