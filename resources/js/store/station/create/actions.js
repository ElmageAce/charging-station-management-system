import * as types from "./actionTypes";
import httpRequest from "../../../utils/http";

const createCreateRequestAction = () => ({type: types.STATION_CREATE_REQUEST})
const createCreateSuccessAction = (data) => ({type: types.STATION_CREATE_SUCCESS, data})
const createCreateFailureAction = (error) => ({type: types.STATION_CREATE_FAILURE, error})

export const sendStationCreateRequest = (data) => dispatch => {
    dispatch(createCreateRequestAction())

    const callbacks = {
        success: createCreateSuccessAction,
        failure: createCreateFailureAction
    }

    dispatch(httpRequest({url: '/api/station', method: 'post', data}, callbacks))
}
