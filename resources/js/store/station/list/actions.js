import * as types from './actionTypes'
import httpRequest from "../../../utils/http";

const createIndexRequestAction = () => ({type: types.STATIONS_INDEX_REQUEST})
const createIndexSuccessAction = (data) => ({type: types.STATIONS_INDEX_SUCCESS, data})
const createIndexFailureAction = (error) => ({type: types.STATIONS_INDEX_FAILURE, error})

export const sendStationsIndexRequest = (page = 1) => dispatch => {
    dispatch(createIndexRequestAction())
    const callbacks = {
        success: createIndexSuccessAction,
        failure: createIndexFailureAction
    }

    dispatch(httpRequest({url: '/api/station', method: 'get', params: {page}}, callbacks))
};
