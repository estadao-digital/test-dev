import { handleResponse, handleError } from "./apiUtils";
const baseUrl = process.env.REACT_APP_API_URL + "/api/v1/marcas/";

export function getBrands() {
  return fetch(baseUrl)
    .then(handleResponse)
    .catch(handleError);
}
