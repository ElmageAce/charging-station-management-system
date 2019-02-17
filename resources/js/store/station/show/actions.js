import * as types from './actionTypes'
import httpRequest from "../../../utils/http";

const createShowRequestAction = () => ({type: types.STATION_SHOW_REQUEST})
const createShowSuccessAction = (data) => ({type: types.STATION_SHOW_SUCCESS, data})
const createShowFailureAction = (error) => ({type: types.STATION_SHOW_FAILURE, error})

export const sendStationShowRequest = (id) => dispatch => {
    dispatch(createShowRequestAction())
    const callbacks = {
        success: (data) => dispatch => {
            dispatch(createShowSuccessAction(data))
        },
        failure: createShowFailureAction
    }

    dispatch(httpRequest({url: '/api/station/' + id, method: 'get'}, callbacks))
};
