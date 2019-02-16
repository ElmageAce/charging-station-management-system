import React, {useState} from 'react'
import PropTypes from 'prop-types'
import {location as defaultLocation} from "../../../utils/defaults";
import Map from "../../../ui/Map";
import Marker from "../../../ui/Marker";

const AddNewStationRow = (props) => {
    // Declare a new state variable, which we'll call "count"
    const [isModalVisible, setIsModalVisible] = useState(false);
    const [hasError, setHasError] = useState(false);
    const [location, setLocation] = useState(defaultLocation);
    const [stationName, setStationName] = useState('');

    const {coordinates} = location;

    const handleSubmit = (e) => {
        e.preventDefault()

        if (stationName.trim()) {
            props.submit({name: stationName, location})

            closeModal(e)

            setHasError(false)
        } else {
            setHasError(true)
        }
    }

    const closeModal = (e) => {
        e.stopPropagation()
        e.preventDefault()

        setIsModalVisible(false)
    }

    const onChangeInput = event => {
        setStationName(event.target.value)
        setHasError(false)
    }

    return (
        <li className="list-group-item d-flex justify-content-between align-items-center list-group-item-action">
            <button type="button" className="btn btn-primary btn-sm" onClick={() => setIsModalVisible(true)}>
                Add station
            </button>

            {isModalVisible && <div className="modal" style={{display: 'block'}} tabIndex="-1" role="dialog">
                <div className="modal-backdrop fade show" style={{zIndex: 0}} onClick={closeModal}/>

                <div className="modal-dialog" role="document">
                    <div className="modal-content">
                        <div className="modal-header">
                            <h5 className="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" className="close" onClick={closeModal}>
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div className="modal-body">
                            <input className="form-control"
                                   style={{marginBottom: '10px'}}
                                   value={stationName}
                                   onChange={onChangeInput}
                                   placeholder={'Please enter new station name'}/>
                            {hasError && <small className="text-danger">Please enter correct station name!</small>}
                            <Map zoom={13}
                                 onChange={({center}) => setLocation({
                                     ...location,
                                     coordinates: [center.lng, center.lat]
                                 })}
                                 center={{
                                     lat: coordinates[1],
                                     lng: coordinates[0]
                                 }}>
                                <Marker lat={coordinates[1]}
                                        lng={coordinates[0]}
                                        text={'S'}
                                        zIndex={1}/>
                            </Map>
                            <small>Coordinates: {coordinates[1]}, {coordinates[0]}</small>
                        </div>
                        <div className="modal-footer">
                            <button type="button" className="btn btn-secondary" onClick={closeModal}>Close</button>
                            <button type="button" className="btn btn-primary" onClick={handleSubmit}>Save changes
                            </button>
                        </div>
                    </div>
                </div>

            </div>}
        </li>
    )

}

AddNewStationRow.propTypes = {
    station: PropTypes.object
}

export default AddNewStationRow
