import Link from "next/link";
import { useRouter } from 'next/router'
import Button from 'react-bootstrap/Button';

import { useState, useEffect } from 'react'
import { FaArrowAltCircleLeft } from "react-icons/fa";

export const CarCard = () => {
  const router = useRouter()
  const { id } = router.query
  const { method } = router.query
  const url: string = `http://0.0.0.0/api/carros/${id}`
  const [loading, setLoading] = useState(false)
  const [data, setData] = useState(null)

  const fetchData = async (url: RequestInfo, method: string) => {
    try {
      setLoading(true)

      const response = await fetch(url, {
        "method": method
      })

      const data = await response.json()
      if (!data) throw 'No car found!'
      setData(data)

    } catch (error) {
      console.log(error);
    }
    finally {
      setLoading(false)
    }
  }

  useEffect(() => {
    fetchData(url, method)
  }, []);

  return (<>
    {loading && !data && <div className='container'><p>loading</p></div>
    }
    {
      data && <div key={data.id} className="container">
        <h1 className="card-title">{data.brand}</h1>
        <h3 className="card-content">{`${data.model} - ${data.year}`}</h3>
        <p>Updated on {data.updated_at.replace(".000000Z", "").replace("T", " at ")}</p>
        <Link className="" href={`/`}>
          <Button variant="primary">Back {FaArrowAltCircleLeft()}</Button>{''}
        </Link>
      </div>
    }
  </>)
}

export default CarCard;