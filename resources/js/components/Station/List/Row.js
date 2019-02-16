import React, {useState} from 'react'
import PropTypes from 'prop-types'
import {connect} from 'react-redux'
import {sendStationUpdateRequest} from "../../../store/station/update/actions";

const Row = (props) => {
    // Declare a new state variable, which we'll call "count"
    const [isEditMode, setIsEditMode] = useState(false);
    const [stationName, setStationName] = useState(props.station.name);

    const toggleIsEditMode = (e) => {
        e.stopPropagation();
        setIsEditMode(!isEditMode)
    }

    const handleSubmit = (e) => {
        e.preventDefault()

        props.dispatch(sendStationUpdateRequest(props.station, {name: stationName}))

        toggleIsEditMode(e)
    }

    if (isEditMode) {
        return (
            <li className="list-group-item d-flex justify-content-between align-items-center list-group-item-action">
                <form onSubmit={handleSubmit}>
                    <input className="form-control" value={stationName} onChange={e => setStationName(e.target.value)}/>
                </form>
                <button className="btn btn-success btn-sm" onClick={handleSubmit}>
                    <i className="fas fa-check"/>
                </button>
            </li>
        )
    } else {
        return (
            <li className="list-group-item d-flex justify-content-between align-items-center list-group-item-action"
                onClick={() => _history.push('/station/' + props.station.id)}>
                <span>
                    {stationName}
                    <small>({props.station.company.name})</small>
                </span>

                <button className="btn btn-primary btn-sm" onClick={toggleIsEditMode}>
                    <i className="fas fa-pencil-alt"/>
                </button>
            </li>
        )
    }
}

Row.propTypes = {
    station: PropTypes.object.isRequired
}

export default connect()(Row)
