import * as types from './actionTypes'
import httpRequest from "../../../utils/http";

const createSearchRequestAction = () => ({type: types.STATIONS_SEARCH_REQUEST})
const createSearchSuccessAction = (data) => ({type: types.STATIONS_SEARCH_SUCCESS, data})
const createSearchFailureAction = (error) => ({type: types.STATIONS_SEARCH_FAILURE, error})

export const sendStationsSearchRequest = (latitude, longitude, radius, page = 1) => dispatch => {
    dispatch(createSearchRequestAction())
    const callbacks = {
        success: createSearchSuccessAction,
        failure: createSearchFailureAction
    }

    dispatch(httpRequest({
        url: '/api/station/index-within-radius/' + latitude + '/' + longitude + '/' + radius,
        method: 'get',
        params: {page}
    }, callbacks))
};
