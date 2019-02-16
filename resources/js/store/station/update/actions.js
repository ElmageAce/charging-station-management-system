import * as types from "./actionTypes";
import httpRequest from "../../../utils/http";

const createUpdateRequestAction = () => ({type: types.STATION_UPDATE_REQUEST})
const createUpdateSuccessAction = (data) => ({type: types.STATION_UPDATE_SUCCESS, data})
const createUpdateFailureAction = (error) => ({type: types.STATION_UPDATE_FAILURE, error})

export const sendStationUpdateRequest = (station, data) => dispatch => {
    dispatch(createUpdateRequestAction())

    const callbacks = {
        success: createUpdateSuccessAction,
        failure: createUpdateFailureAction
    }

    dispatch(httpRequest({url: '/api/station/' + station.id, method: 'put', data}, callbacks))
}
