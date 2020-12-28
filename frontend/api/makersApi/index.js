import { HttpClient } from '../../interfaces'

const MAKERS_API = '/api/makers'

export default {
  takeAll: () => HttpClient.get(MAKERS_API)
}
