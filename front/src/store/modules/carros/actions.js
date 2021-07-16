export function addCarRequest(data) {
  return {
    type: '@car/ADD_REQUEST',
    payload: { data },
  };
}

export function addCarSuccess(carro) {
  return {
    type: '@car/ADD_SUCCESS',
    payload: { carro },
  };
}

export function addCarFailure() {
  return {
    type: '@car/ADD_FAILURE',
  };
}

export function removeCar(id) {
  return {
    type: '@car/REMOVE',
    id,
  };
}

export function updateCarRequest(id, carro) {
  return {
    type: '@car/UPDATE_REQUEST',
    id,
    payload: { carro },
  };
}

export function updateCarSuccess(carro) {
  return {
    type: '@car/UPDATE_SUCCESS',
    carro,
  };
}

export function reloadComplete() {
  return {
    type: '@car/RELOAD',
  };
}

export function updateCarFailure() {
  return {
    type: '@car/UPDATE_FAILURE',
  };
}
