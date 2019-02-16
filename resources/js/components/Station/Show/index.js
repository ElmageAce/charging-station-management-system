import React, {Component} from "react";
import Container from "../../../ui/Container";
import Map from "../../../ui/Map";
import {sendStationShowRequest} from "../../../store/station/show/actions";
import {connect} from 'react-redux'
import Marker from '../../../ui/Marker'

class Show extends Component {
    render() {
        console.log(this.props.station)
        return (
            <Container>
                <div className="card">
                    <div className="card-header">{this.props.station.name}</div>

                    <div className="card-body">
                        <div className="row">
                            <div className="col-md-6 col-sm-12">
                                <form>
                                    <div className="form-group row">
                                        <label htmlFor="staticId" className="col-sm-4 col-form-label">Id</label>
                                        <div className="col-sm-8">
                                            <span className="form-control-plaintext" id="staticId">
                                                {this.props.station.id}
                                            </span>
                                        </div>
                                    </div>
                                    <div className="form-group row">
                                        <label htmlFor="staticParentName"
                                               className="col-sm-4 col-form-label">Company</label>
                                        <div className="col-sm-8">
                                            <span className="form-control-plaintext" id="staticParentName"
                                                  onClick={() => _history.push('/company/' + this.props.station.company.id)}>
                                                {this.props.station.company.name}
                                            </span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div className="col-md-6 col-sm-12">
                                <Map zoom={13}
                                     center={{
                                         lat: this.props.station.location.coordinates[1],
                                         lng: this.props.station.location.coordinates[0]
                                     }}>
                                    <Marker
                                        lat={this.props.station.location.coordinates[1]}
                                        lng={this.props.station.location.coordinates[0]}
                                        text={'S'}
                                        zIndex={1}
                                    />
                                </Map>
                            </div>
                        </div>
                    </div>
                </div>
            </Container>
        )
    }

    componentDidMount() {
        this.props.fetchStation()
    }
}

const mapStateToProps = state => ({
    station: state.station.show.station
})
const mapDispatchToProps = (dispatch, ownProps) => ({
    fetchStation: () => dispatch(sendStationShowRequest(ownProps.match.params.id))
})

export default connect(mapStateToProps, mapDispatchToProps)(Show)
