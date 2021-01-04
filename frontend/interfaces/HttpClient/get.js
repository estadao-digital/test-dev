import request from './request'

function get (url) {
  return request(url, {
    method: 'GET'
  })
}

export default get
