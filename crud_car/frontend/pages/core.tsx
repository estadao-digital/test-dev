import type { NextPage } from 'next'
import { useState, useEffect } from 'react'

const Cars: NextPage = (url: RequestInfo = "http://0.0.0.0/api/carros", method: string = "get") => {

  const [loading, setLoading] = useState(false)
  const [data, setData] = useState(null)

  const fetchData = async (url: RequestInfo, method: string) => {
    try {
      setLoading(true)

      const response = await fetch(url, {
        "method": method.toUpperCase()
      })

      const data = await response.json()
      if (!data) throw 'No cars found!'
      setData(data)
      console.log(data);


    } catch (error) {
      console.log(error);
    }
    finally {
      setLoading(false)
    }
  }

  return useEffect(() => {
    fetchData(url, method)
  }, [])
}

export default Cars
