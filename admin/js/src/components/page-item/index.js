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
                    <button>Save</button>
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