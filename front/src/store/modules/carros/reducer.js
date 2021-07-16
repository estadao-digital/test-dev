import produce from 'immer';

const INITIAL_STATE = {
  carro: null,
  reload: false,
};

export default function carro(state = INITIAL_STATE, action) {
  return produce(state, draft => {
    switch (action.type) {
      case '@car/ADD_SUCCESS': {
        draft.carro = action.payload.carro;
        draft.reload = true;
        break;
      }

      case '@car/UPDATE_SUCCESS': {
        draft.carro = action.carro;
        draft.reload = true;
        break;
      }

      case '@car/REMOVE': {
        draft.carro = null;
        draft.reload = true;
        break;
      }

      case '@car/RELOAD': {
        console.log('reload');
        draft.reload = false;
        break;
      }

      default:
    }
  });
}
