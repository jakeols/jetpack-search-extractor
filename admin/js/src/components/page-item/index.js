import { h, Component } from "preact";
import "./style.scss";

export default class PageItem extends Component {
    constructor(props){
        super(props);
        this.state = {
            editSelected: false,
            selectedMeta: [],
            showSuccessMessage: false,
        }
    }

    handleEditButtonClick = () => {
        this.setState({editSelected: true});
    }

    handleCloseButtonClick = () => {
        this.setState({editSelected: false});
    }

    /**
     * this will send the meta to our 
     * rest api (process it by saving into meta)
     */
    saveMeta = () => {
        const data = { fields: this.state.selectedMeta };
        console.log(data);
        // rest api url that has been created is: /wp-json/jpsearchextractor/v1/meta/{id}
        fetch(`/wp-json/jpsearchextractor/v1/meta/${this.props.data.id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
        })
        .then((response) => response.json())
        .then((data) => {
            if(data.response === 200){
                this.setState({showSuccessMessage: true, editSelected: false});
            }
        })
        .catch((error) => {
        console.error('Error:', error);
        });
    }

    handleMetaClick = (e) => {
        this.setState(previousState => ({
            selectedMeta: [...previousState.selectedMeta, e.target.value]
        }));
    }

    RenderEdits = () => {
        if(this.state.editSelected){
            const meta = Object.keys(this.props.data.ACF);
            console.log(meta);
            return (
                <div>
                    <div>Select which keys you would like added to the index:</div>
                    <div>
                        {meta.map((key, i) =>
                        <div>
                            <input type="checkbox" onClick={this.handleMetaClick} id={i} name={key} value={key} />
                            <label for={i} key={i}>{key}</label>
                        </div>
                        )}
                    </div>
                    <button onClick={this.saveMeta}>Save</button>
                    <button onClick={this.handleCloseButtonClick}>Cancel</button>
                </div>
            )
        }
        else {
            return (
                <button onClick={this.handleEditButtonClick}>Edit page meta</button>
            )
        }
    }
    

    render(){
        return (
            <div>
                <p>{this.props.data.title.rendered}</p>
                {this.state.showSuccessMessage &&
                    <p>Your post meta was successfully updated!</p>
                }
                <this.RenderEdits />
            </div>
        )
    }

}