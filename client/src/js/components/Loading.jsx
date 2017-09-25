import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';

// exported for tests
export class Loading extends Component {
  render() {
    const { isLoading } = this.props;
    if (isLoading) {
      return (
        <div className="loading show">
          <div className="loading-content">
            <div className="spinner" />
            <span>Loading</span>
          </div>
        </div>
      );
    }
    return (
      <div className="loading" />
    );
  }
}

Loading.propTypes = {
  isLoading: PropTypes.bool.isRequired,
};

function mapStateToProps(state) {
  return {
    isLoading: state.map.isLoading,
  };
}

export default connect(mapStateToProps)(Loading);
