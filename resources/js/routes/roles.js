function Page (path) {
	return () => import(/* webpackChunkName: '' */ `../pages/${path}`).then(m => m.default || m)
}

export default [
	// Role Routes...
	{
		path: '/admin/role/:id/edit-role',
        name: 'admin.role.edit',
		component: Page('Admin/Roles'),
	},
]
