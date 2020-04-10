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
            return (
                <div>
                    <div>can edit</div>
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