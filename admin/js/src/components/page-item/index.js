import { h, Component } from "preact";
import "./style.scss";

export default class PageItem extends Component {
    constructor(props){
        super(props);
        this.state = {
            editSelected: false,
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
        // send to api -> using "hero, card_meta" as default for now 
        const data = { fields: ["hero", "card_meta"] };

        // rest api url that has been created is: /wp-json/jpsearchextractor/v1/meta/{id}

        fetch('/wp-json/jpsearchextractor/v1/meta/112', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
        })
        .then((response) => response.json())
        .then((data) => {
        console.log('Success:', data);
        })
        .catch((error) => {
        console.error('Error:', error);
        });
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
                            <input type="checkbox" id={i} name={key} value={key} />
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
                <this.RenderEdits />
            </div>
        )
    }

}