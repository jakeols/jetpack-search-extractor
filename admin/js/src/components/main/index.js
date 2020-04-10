import { h, Component } from "preact";
import Header from '../header';
import ContentChooser from '../content-chooser';
import PageList from '../page-list';
import "./style.scss";

export default class Main extends Component {

    constructor(props){
        super(props);
        this.state = {
            pages: [],
        }
    }

    updatePages = (data) => {
        // check data
        console.log(data);
        // set states
        this.setState({pages: data});
    }
    
    render(){
        return (
            <div>
                <Header />
                <ContentChooser callback={this.updatePages} />
                <PageList data={this.state.pages} />
            </div>
        )
    }
}