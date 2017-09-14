import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';

import {
  CellMeasurer,
  CellMeasurerCache,
  AutoSizer,
  List as VirtualList,
} from 'react-virtualized';

import { openMarker } from 'actions/mapActions';
import Location from 'components/list/Location';

/**
 * The List component.
 * Renders the location list.
 *
 * some of the code related to virtualization came from:
 * https://github.com/bvaughn/tweets/blob/37d0139736346db16b9681d5b859a4e127964518/src/components/TweetList.js
 */
class List extends Component {
  /**
   * Used to create the Map.
   * needed to allow use of this keyword in handler.
   * @param props
   */
  constructor(props) {
    super(props);
    // bind actions/handlers
    this.handleLocationClick = this.handleLocationClick.bind(this);
    this.renderRow = this.renderRow.bind(this);
    this.resizeAll = this.resizeAll.bind(this);

    // create variables
    this.cache = new CellMeasurerCache({ defaultHeight: 85, fixedWidth: true });
    this.mostRecentWidth = 0;
    this.lastDistance = -1;
    this.resizeAllFlag = false;
  }

  /**
   * Called after the component updates
   * @param prevProps
   */
  componentDidUpdate(prevProps) {
    const { locations } = this.props;
    if (this.resizeAllFlag) {
      this.resizeAllFlag = false;
      this.cache.clearAll();
      if (this.list) {
        this.list.recomputeRowHeights();
      }
    } else if (locations !== prevProps.locations) {
      const index = prevProps.locations.length;
      this.cache.clear(index, 0);
      if (this.list) {
        this.list.recomputeRowHeights(index);
      }
    }
    this.scrollToCurrentIndex();
  }

  /**
   * Re-calculates heights for rows
   */
  resizeAll() {
    this.resizeAllFlag = false;
    this.cache.clearAll();
    if (this.list) {
      this.list.recomputeRowHeights();
    }

    const { locations } = this.props;
    if (locations.length > 0) {
      this.lastDistance = locations[0].Distance;
    }
  }

  scrollToCurrentIndex() {
    const { locations, current } = this.props;
    let index = locations.findIndex(l => l.ID === current);
    if (index === -1) {
      index = 0;
    }
    this.list.scrollToRow(index);
  }

  /**
   * Handles a list item click
   * @param target
   */
  handleLocationClick(target) {
    const { dispatch } = this.props;
    dispatch(openMarker(target));
  }

  /**
   * Renders the row
   *
   * @param index
   * @param key
   * @param style
   * @param parent
   * @return {XML}
   */
  renderRow({ index, key, style, parent }) {
    const { current, search, unit, template, locations } = this.props;
    const location = locations[index];
    return (
      <CellMeasurer
        cache={this.cache}
        columnIndex={0}
        key={key}
        parent={parent}
        rowIndex={index}
      >
        <Location
          key={key}
          style={style}
          location={location}
          index={index}
          current={current === location.ID}
          search={search.length > 0}
          unit={unit}
          onClick={this.handleLocationClick}
          template={template}
        />
      </CellMeasurer>
    );
  }

  /**
   * Renders the component
   * @returns {XML}
   */
  render() {
    const { locations, current } = this.props;
    return (
      <div className="loc-list" role="list">
        <AutoSizer>
          {({ width, height }) => {
            if ((this.mostRecentWidth && this.mostRecentWidth !== width) ||
              (locations.length > 0 && this.lastDistance !== locations[0].Distance)) {
              this.resizeAllFlag = true;
              setTimeout(this.resizeAll, 0);
            }

            this.mostRecentWidth = width;

            return (
              <VirtualList
                ref={(list) => {
                  this.list = list;
                }}
                current={current}
                deferredMeasurementCache={this.cache}
                width={width}
                height={height}
                rowCount={locations.length}
                rowHeight={this.cache.rowHeight}
                rowRenderer={this.renderRow}
                scrollToAlignment="start"
              />
            );
          }}
        </AutoSizer>
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
