import request from './request'

function del (url) {
  return request(url, {
    method: 'DELETE'
  })
}

export default del
