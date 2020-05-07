import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/admin/getList',
    method: 'get',
    params: query
  })
}

export function modifyStatus(params) {
  return request({
    url: '/admin/modifyStatus',
    method: 'get',
    params
  })
}

export function addAddmin(data) {
  return request({
    url: '/admin/addAddmin',
    method: 'post',
    data
  })
}

export function updateAddmin(data) {
  return request({
    url: '/admin/updateAddmin',
    method: 'post',
    data
  })
}

export function fetchArticle(id) {
  return request({
    url: '/vue-element-admin/article/detail',
    method: 'get',
    params: {
      id
    }
  })
}

export function fetchPv(pv) {
  return request({
    url: '/vue-element-admin/article/pv',
    method: 'get',
    params: {
      pv
    }
  })
}

export function createArticle(data) {
  return request({
    url: '/vue-element-admin/article/create',
    method: 'post',
    data
  })
}

export function updateArticle(data) {
  return request({
    url: '/vue-element-admin/article/update',
    method: 'post',
    data
  })
}
