import React from 'react';

class SearchBar extends React.Component {

    mappedRadii() {
        return this.props.radii.map(radius =>
            <option value="radius">radius</option>
        );

    }

    radius() {
        if (this.props.radii !== undefined) {
            return (
                <div className="field dropdown form-group--no-label">

                    <div className="middleColumn">
                        <select name="Radius" className="dropdown form-group--no-label">

                            <option value="" selected="selected">radius
                            </option>
                            {this.mappedRadii()}
                        </select>
                    </div>
                </div>
            );
        } else {
            return null;
        }
    }

    render() {
        return (
            <form>
                <fieldset>
                    <div className="field text form-group--no-label">
                        <div className="middleColumn">
                            <input type="text" name="adress" className="text form-group--no-label" required="required"
                                   aria-required="true" placeholder="address or zip code"/>
                        </div>
                    </div>

                    {this.radius()}

                    <div className="clear">

                    </div>
                </fieldset>

                <div className="btn-toolbar">
                    <input type="submit" name="action_doFilterLocations" value="Search" className="action"/>
                </div>
            </form>
        );
    }
}

export default SearchBar;