import React, {Component} from 'react'
import PropTypes from 'prop-types'

import GoogleMap from 'google-map-react';

class Map extends Component {


    render() {
        return (
            <div className="col-sm-12">
                <GoogleMap
                    style={{minHeight: '300px', maxHeight: '500px',}}
                    // apiKey={YOUR_GOOGLE_MAP_API_KEY} // set if you need stats etc ...
                    center={this.props.center}
                    zoom={this.props.zoom}
                    onChange={this.props.onChange}>
                    {this.props.children}
                </GoogleMap>
            </div>
        )
    }
}

Map.propTypes = {
    center: PropTypes.object.isRequired,
    zoom: PropTypes.number.isRequired,
    onChange: PropTypes.func
}

Map.defaultProps = {
    onBoundsChange: () => {
    }
}

export default Map
