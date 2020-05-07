/** When your routing table is too long, you can split it into small modules **/

import Layout from '@/layout'

const systemRouter = {
  path: '/system',
  component: Layout,
  name: 'System',
  meta: {
    title: '系统管理',
    icon: 'user'
  },
  children: [{
    path: 'admin/list',
    name: 'AdminList',
    component: () => import('@/views/system/admin/list'),
    meta: {
      title: '后台管理员'
    }
  },
  {
    path: 'role',
    name: 'RoleIndex',
    component: () => import('@/views/system/role/index'),
    meta: {
      title: '角色管理'
    }
  }]
}

export default systemRouter
