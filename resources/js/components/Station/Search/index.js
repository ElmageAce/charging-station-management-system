import React, {Component} from "react";
import Container from "../../../ui/Container";
import Map from "../../../ui/Map";
import Marker from "../../../ui/Marker";
import {connect} from 'react-redux'
import ListCard from "../List/ListCard";
import {location} from "../../../utils/defaults";
import {sendStationsSearchRequest} from "../../../store/station/search/actions";
import Paginator from "../../../ui/Paginator";

class Search extends Component {
    constructor(props) {
        super(props)

        this.state = {
            centerPoint: location,
            rangeValue: 20
        }
    }

    render() {
        const {paginated_list} = this.props
        const {coordinates} = this.state.centerPoint;
        const {rangeValue} = this.state;

        const paginator = <Paginator paginated_list={paginated_list}
                                     onChangePage={page => this.props.searchStations(coordinates[1], coordinates[0], (rangeValue * 100) + 'm', page)}/>

        return (
            <Container>
                <div className="card">
                    <div className="card-body">
                        <div className="row">
                            <div className="col-md-6 col-sm-12">
                                <Container>
                                    {paginator}

                                    <ListCard paginated_list={paginated_list}/>

                                    {paginator}
                                </Container>
                            </div>
                            <div className="col-md-6 col-sm-12">

                                <Map zoom={11}
                                     onChange={({center}) => this.setState({
                                         centerPoint: {
                                             ...location,
                                             coordinates: [center.lng, center.lat]
                                         }
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
                                <form style={{marginTop: '20px'}}>
                                    <div className="form-group row">
                                        <label htmlFor="distanceId" className="col-sm-4 col-form-label">Distance</label>
                                        <div className="col-sm-8">
                                            <input type="range"
                                                   className="form-control-range"
                                                   id="distanceId"
                                                   value={rangeValue}
                                                   onChange={e => this.setState({rangeValue: e.target.value})}/>
                                            <small>{rangeValue * 100} meter</small>
                                        </div>
                                        <div className="form-group row">
                                            <label htmlFor="coordinatesId"
                                                   className="col-sm-4 col-form-label">coordinates</label>
                                            <div className="col-sm-8">
                                                <span className="form-control-plaintext" id="coordinatesId">
                                                    {coordinates[1]}, {coordinates[0]}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <button className="btn btn-success btn-sm" onClick={() => {
                                    this.props.searchStations(coordinates[1], coordinates[0], (rangeValue * 100) + 'm')
                                }}>
                                    Search
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </Container>
        )
    }

    // componentDidMount() {
    //     this.props.fetchStation()
    // }
}

const mapStateToProps = state => ({
    paginated_list: state.station.search.paginated_list
})
const mapDispatchToProps = dispatch => ({
    searchStations: (latitude, longitude, radius, page = 1) => dispatch(sendStationsSearchRequest(latitude, longitude, radius, page))
})

export default connect(mapStateToProps, mapDispatchToProps)(Search)
