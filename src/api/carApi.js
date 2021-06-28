import { handleResponse, handleError } from "./apiUtils";
const baseUrl = process.env.REACT_APP_API_URL + "/api/v1/carros/";

export function getCars() {
  return fetch(baseUrl)
    .then(handleResponse)
    .catch(handleError);
}

export function getCarById(id) {
  return fetch(baseUrl + id)
    .then(response => {
      if (!response.ok) throw new Error("Network response was not ok.");
      return response.json().then(cars => {
        if (cars.data.length !== 1) throw new Error("Car not found: " + id);
        return cars.data; // should only find one car for a given id, so return it.
      });
    })
    .catch(handleError);
}

export function saveCar(car) {
  return fetch(baseUrl + (car.id || ""), {
    method: car.id ? "PUT" : "POST", // POST for create, PUT to update when id already exists.
    headers: { "content-type": "application/json" },
    body: JSON.stringify({
      ...car,
      // Parse year and brandId to a number (in case it was sent as a string).
      year: parseInt(car.year, 10),
      brandId: parseInt(car.brandId, 10)
    })
  })
    .then(handleResponse)
    .catch(handleError);
}

export function deleteCar(carId) {
  return fetch(baseUrl + carId, { method: "DELETE" })
    .then(handleResponse)
    .catch(handleError);
}
