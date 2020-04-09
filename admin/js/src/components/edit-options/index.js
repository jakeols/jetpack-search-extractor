import { h, Component } from 'preact';

export default class EditOptions extends Component {
    constructor(props){
        super(props);
        this.state = {
            pageData: {}
        };
    }

    componentWillReceiveProps(){
        // get page data using page id props
        if(this.props.page){
            this.getPageContent(this.props.page.id);
        }
    }

    getPageContent = (id) => {
        fetch(`/wp/v2/pages/${id}`)
        .then((res) => {
            return res.json();
        })
        .then((data) => {
            console.log(data);
            this.setState({pageData: data});
        })
    }

    render(){
        return this.props.page && (
            <div>
                <h4>Editing Options for: </h4>
            </div>
        )
    }
}