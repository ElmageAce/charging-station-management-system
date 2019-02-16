import React, {Component} from 'react'
import PropTypes from 'prop-types'

import {
    greatPlaceCircleStyle,
    greatPlaceCircleStyleHover,
    greatPlaceStickStyle,
    greatPlaceStickStyleHover,
    greatPlaceStickStyleShadow,
    greatPlaceStyle
} from './style.js'

class Marker extends Component {
    constructor(props) {
        super(props)
    }

    render() {
        const {text, zIndex} = this.props

        const style = {
            ...greatPlaceStyle,
            zIndex: this.props.$hover ? 1000 : zIndex
        }

        const circleStyle = this.props.$hover ? greatPlaceCircleStyleHover : greatPlaceCircleStyle
        const stickStyle = this.props.$hover ? greatPlaceStickStyleHover : greatPlaceStickStyle

        return (
            <div style={style}>
                <div style={greatPlaceStickStyleShadow}/>
                <div style={circleStyle}>
                    {text}
                </div>
                <div style={stickStyle}/>
            </div>
        )
    }
}

Marker.propTypes = {
// GoogleMap pass $hover props to hovered components
// to detect hover it uses internal mechanism, explained in x_distance_hover example
    $hover: PropTypes.bool,
    text: PropTypes.string,
    zIndex: PropTypes.number
}

export default Marker
