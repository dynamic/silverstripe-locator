import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';

import { openMarker } from 'actions/mapActions';
import Location from 'components/list/Location';

/**
 * The List component.
 * Renders the location list.
 */
class List extends Component {
  /**
   * Used to create the Map.
   * needed to allow use of this keyword in handler.
   * @param props
   */
  constructor(props) {
    super(props);
    this.handleLocationClick = this.handleLocationClick.bind(this);
  }

  handleLocationClick(target) {
    this.props.dispatch(openMarker(target));
  }

  /**
   * Renders the locations
   * @returns {*}
   */
  renderLocations() {
    const { current, search, unit, template, locations } = this.props;
    if (locations !== undefined) {
      return locations.map((location, index) =>
        (
          <Location
            key={location.ID}
            index={index}
            location={location}
            current={current === location.ID}
            search={search}
            unit={unit}
            onClick={this.handleLocationClick}
            template={template}
          />
        ),
      );
    }
    return (<li>
      No locations
    </li>);
  }

  /**
   * Renders the component
   * @returns {XML}
   */
  render() {
    return (
      <div className="loc-list">
        <ul>
          {this.renderLocations()}
        </ul>
      </div>
    );
  }
}

/**
 * Defines the prop types
 * @type {{locations: *}}
 */
List.propTypes = {
  // eslint-disable-next-line react/forbid-prop-types
  locations: PropTypes.array,
  current: PropTypes.number,
  search: PropTypes.string,
  unit: PropTypes.string.isRequired,
  dispatch: PropTypes.func.isRequired,
  template: PropTypes.func.isRequired,
};

/**
 * Defines the default values of the props
 * @type {{locations: {edges: Array}}}
 */
List.defaultProps = {
  locations: [],
  current: -1,
  search: '',
};

/**
 * Maps that state to props
 * @param state
 * @returns {{current}}
 */
function mapStateToProps(state) {
  return {
    current: state.map.current,
    search: state.search.address,
    unit: state.settings.unit,
    template: state.settings.listTemplate,
    locations: state.locations.locations,
  };
}


/**
 * export the Map Component
 */
export default connect(mapStateToProps)(List);
