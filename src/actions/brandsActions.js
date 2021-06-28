import dispatcher from "../appDispatcher"
import * as brandApi from "../api/brandApi"
import actionTypes from "./actionTypes"

export function loadBrands() {
  return brandApi
    .getBrands()
    .then(brands => {
      dispatcher.dispatch({
        actionType: actionTypes.LOAD_BRANDS,
        brands: brands.data
      })
    })
}
