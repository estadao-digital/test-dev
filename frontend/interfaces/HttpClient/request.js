import DEFAULT_CONFIG from './defaultConfig'

async function request (url, config) {
  try {
    const response = await window.fetch(url, {
      ...DEFAULT_CONFIG,
      ...config
    })

    if (response.ok) {
      const data = await response.json()

      return {
        error: false,
        data
      }
    } else {
      const { statusText: message, status } = response

      return {
        error: {
          message,
          status
        }
      }
    }
  } catch (error) {
    return error
  }
}

export default request
