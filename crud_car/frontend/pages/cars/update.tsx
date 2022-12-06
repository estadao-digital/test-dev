import { Button, Form } from "react-bootstrap";
import { FaArrowAltCircleLeft, FaCheck } from "react-icons/fa";
import CustomHead from "../head";
import Link from "next/link";
import { useRouter } from 'next/router'
import { useState, useEffect } from 'react'
import CustomLoading from "../loading";
import CustomAlert from "../alert";




const UpdateCar: NextPage = () => {

  const router = useRouter()
  const { id } = router.query
  const url = `http://0.0.0.0/api/carros/${id}`
  const [loading, setLoading] = useState(false)
  const [carData, setData] = useState(null)

  const updateCar = async (e, url: string) => {
    let response = {};
    let message = "";
    const data = {
      "model": e.target.form.model.value,
      "brand": e.target.form.brand.value,
      "year": e.target.form.year.value,
      "updated_at": new Date()
    };

    try {
      response = await fetch(url, {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data),
      })

      if (response.status === 200) {
        CustomAlert({ message: "Car deleted successfully.", variant: "success" })
      }

    } catch (error) {
      CustomAlert({ message: error, variant: "danger" })
      throw error;
    } finally {
      router.push(`/`)
    }

  }

  const fetchData = async (method: string) => {
    try {
      setLoading(true)

      const response = await fetch(url, {
        "method": method
      })

      const data = await response.json()
      if (!data) throw 'No car found!'
      setData(data)

    } catch (error) {
      console.log("error: ", error);
      throw error;
    }
    finally {
      setLoading(false)
    }
  }

  useEffect(() => {
    fetchData("GET")
  }, []);

  return (
    <>
      {CustomHead("Update Car")}
      <div className="form-container m-3">
        <h1>Update Car</h1>

        {loading && !carData && CustomLoading()}
        {!loading && carData &&
          <div>

            <Form>
              <label htmlFor="brand">Car Brand: </label>
              <input type="text" id="brand" name="brand" defaultValue={carData.brand} />
              <br />
              <label htmlFor="model">Car Model: </label>
              <input type="text" id="model" name="model" defaultValue={carData.model} />
              <br />
              <label htmlFor="year">Car Model's Year: </label>
              <input type="number" placeholder="yyyy" min="1900" max="2099" step="1" id="year" name="year" defaultValue={carData.year} />
              <br />
              <Button variant="primary" onClick={(e) => updateCar(e, url)}>Update <FaCheck /></Button>
            </Form>
            <p>Last Update: {carData.updated_at.replace("T", " at ").replace(".000000Z", "")} </p>

          </div>

        }
        <Link href="/">
          <Button className="my-2" variant="primary">Back <FaArrowAltCircleLeft /></Button>
        </Link>
      </div>
    </>
  )
}

export default UpdateCar;