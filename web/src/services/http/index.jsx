import axios from 'axios'

const API_URL = 'http://localhost:8090'

const http = axios.create({ baseURL: API_URL, timeout: 20000})

export default http;