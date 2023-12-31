const base_url = 'https://prozbot.com/admin_scenario/';
let search_faq_list = [];
let current_scenario = '';

const firstStep = {
    id: 1,
    type: "button",
    shouldBlockInput: false,
    buttons: [
        {value: "1", content: "\u88fd\u54c1\u306e\u4ed5\u69d8\u30fb\u8a73\u7d30\u306b\u3064\u3044\u3066" },
        {value: "2", content: "\u4e0d\u5177\u5408\u30fb\u4fee\u7406\u306e\u3054\u76f8\u8ac7"},
        {value: "3", content: "\u8fd4\u54c1\u30fb\u4ea4\u63db\u306b\u3064\u3044\u3066"},
        {value: "4", content: "\u3054\u6ce8\u6587\u30fb\u914d\u9001\u306b\u3064\u3044\u3066"},
        {value: "23", content: "\u305d\u306e\u4ed6"}
        ],
    messages: [{
        content: "\u304a\u554f\u5408\u305b\u306e\u5185\u5bb9\u3092\u4ee5\u4e0b\u304b\u3089\u304a\u9078\u3073\u3044\u305f\u3060\u304f\u304b\u3001\u3054\u8cea\u554f\u3092\u76f4\u63a5\u5165\u529b\u3057\u3066\u304f\u3060\u3055\u3044\u3002",
        typingDelay: 1000
    }]
};

const scenarioStep = async (id) => {
    let scenario = await getScenarioResult(id);
    if (scenario.child.length == 0) {
        let button = [...scenario.child,
            {content: 'はい', value: 'closing'},
            {content: 'いいえ', value: 'response_no'},
            {content: '戻る', value: scenario.parent.parent_id},];
        if (id == 0) {
            button = [...scenario.child];
        }
        return {
            id: Math.floor(Math.random() * 100000),
            type: 'button',
            shouldBlockInput: false,
            messages: [
                scenario.parent,
                {content: '回答はお役に立ちましたか？', typingDelay: 1000}
            ],
            buttons: button
        };
    } else {
        let button = [...scenario.child, {content: '戻る', value: scenario.parent.parent_id}];
        if (id == 0) {
            button = [...scenario.child];
        }
        return {
            id: Math.floor(Math.random() * 100000),
            type: 'button',
            shouldBlockInput: false,
            messages: [
                scenario.parent
            ],
            buttons: button
        };
    }

};

const getScenarioResult = async (id) => {
    try {
        let scenario = await $.ajax({
            url: base_url + 'api/scenario/' + id,
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            type: 'get',
        });
        return scenario;
    } catch (error) {
        console.error(error);
    }
}

const getSavedReplyResult = async (query) => {
    try {
        let result = await $.ajax({
            url: base_url + 'api/saved_reply?search_text=' + query,
            //contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            type: 'post',
            data: {search_text: query},
        });

        return result;
    } catch (error) {
        console.error(error);
    }
}

const getFaqQueryResults = async (query) => {
    try {
        let result = await $.ajax({
            url: base_url + 'api/faq/?search_text=' + query,
            //contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            type: 'post',
            data: {search_text: query},
        });
        search_faq_list = result;

        return search_faq_list;
    } catch (error) {
        console.error(error);
    }
}
const getWorkTime = async () => {
    try {
        let result = await $.ajax({
            url: base_url + 'api/talk',
            //contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            type: 'post',
        });
        return result;
    } catch (error) {
        console.error(error);
    }
    return 1;
}

const getFaqDetail = async (id) => {
    return search_faq_list[id];
}

const liveChatStep = {
    id: '3',
    type: 'live-chat'
};

const contactStep = {
    id: '4',
    type: 'contact'
};

const qaStep = {
    id: '62',
    type: 'button',
    shouldBlockInput: false,
    messages: [
        {content: 'ご質問を理解できず申し訳ございません。', typingDelay: 1000},
        {content: '再度聞き方を変えてご質問を入力いただくか、以下よりお選びください。', typingDelay: 1000}
    ],
    buttons: [
        {content: 'はじめから始める', value: 'first_step'},
        {content: 'オペレーターと話す', value: 'go_chat'},
        {content: 'チャットを終了する', value: 'closing'}
    ]
};

const goChatStep = async () => {
    const isWork = await getWorkTime();

    if (isWork == 1) {
        return {
            id: '63',
            type: 'live-chat',
            messages: [
                {content: 'お問合せありがとうございます。ご質問をおきかせください。', typingDelay: 100}
            ],
            startImmediately: true
        };
    } else if (isWork == 2) {
        return {
            id: '62',
            type: 'button',
            shouldBlockInput: false,
            messages: [
                {content: 'オペレーターの対応時間外です。オペレーターの対応時間は平日10時～19時です。再度、対応時間にお声がけいただくか以下より選択ください。', typingDelay: 1000}
            ],
            buttons: [
                {content: 'はじめから始める', value: 'first_step'},
                {content: 'メールで質問する', value: 'go_mail'},
                {content: 'よくある質問を見る', value: 'go_faq'},
                {content: 'チャットを終了する', value: 'closing'}
            ]
        }
    }
};

const closingStep = {
    id: '63',
    type: 'text',
    messages: [
        {content: '他にもご質問ございましたらいつでもお声がけください。', typingDelay: 1000}
    ],
};

const articleDetailStep = async (id) => {
    const faq = await getFaqDetail(id);

    return {
        id: '61',
        type: 'button',
        shouldBlockInput: false,
        messages: [
            {content: faq.content, typingDelay: 1000},
            {content: faq.detail, typingDelay: 1000},
            {content: '回答はお役に立ちましたか？', typingDelay: 1000}
        ],
        buttons: [
            {content: 'はい', value: 'closing'},
            {content: 'いいえ', value: 'response_no'},
        ]
    };
};

const getArticlesStep = async (text) => {

    let saveReply = await getSavedReplyResult(text);
    if (saveReply !== "") {
        let scenario = await getScenarioResult(0);
        if (scenario.child.length > 0) {
            return {
                id: Math.floor(Math.random() * 100000),
                type: 'button',
                shouldBlockInput: false,
                messages: [
                    {content: saveReply, typingDelay: 100},
                ],
                buttons: [...scenario.child]
            };
        } else {
            return {
                id: '6',
                type: 'text',
                messages: [
                    {content: saveReply, typingDelay: 100},
                ],
            };
        }
    } else {
        let queryResults = await getFaqQueryResults(text);
        if (queryResults.length === 0) {
            return {
                id: '6',
                type: 'text',
                messages: [
                    {content: 'もう一度言い回しを変えてご質問ください', typingDelay: 100}
                ],
            };
        } else {
            return {
                id: '6',
                type: 'button',
                shouldBlockInput: false,
                messages: [
                    {content: '「' + text + '」に関していかにお探しの質問はありますか？', typingDelay: 100}
                ],
                buttons: [...queryResults, {content: '探している質問はない', value: 'response_no'}]
            };
        }
    }
};

const chatBotCallback = (input, type) => {
    console.log('---------->');
    console.log(input);
    console.log(type);
    console.log('<----------');
    if (input === 'agent') {
        return liveChatStep;
    } else if (input === 'scenario1') {
        return scenarioStep(current_scenario);
    } else if (input === 'contact') {
        return contactStep;
    } else if (input === 'article0') {
        return articleDetailStep(0);
    } else if (input === 'article1') {
        return articleDetailStep(1);
    } else if (input === 'article2') {
        return articleDetailStep(2);
    } else if (input === 'article3') {
        return articleDetailStep(3);
    } else if (input === 'article4') {
        return articleDetailStep(4);
    } else if (input === 'closing') {
        return closingStep;
    } else if (input === 'response_no') {
        return qaStep;
    } else if (input === 'go_chat') {
        return goChatStep();
    } else if (input === 'go_faq') {
        window.location.href = "/go_faq";
        return firstStep;
    } else if (input === 'go_mail') {
        window.location.href = "/go_mail";
        return firstStep;
    } else if (type === 'text') {
        return getArticlesStep(input);
    } else {
        return scenarioStep(input);
    }
}

!function () {
    function e() {
        var e = document.createElement("script");
        e.type = "text/javascript", e.async = !0, e.src = "https://sapporo.wixanswers.com/apps/widget/v1/sapporo/fbd000a0-1f82-49b9-930f-788edf09b680/ja/embed.js";
        var t = document.getElementsByTagName("script")[0];
        t.parentNode.insertBefore(e, t)
    }

    window.addEventListener ? window.addEventListener("load", e) : window.attachEvent("onload", e), window.AnswersWidget = {
        onLoaded: function (e) {
            window.AnswersWidget.queue.push(e)
        }, queue: []
    }
}();

window.AnswersWidget.onLoaded(() => {
        window.AnswersWidget.open();
        window.AnswersWidget.goToChat();
        window.AnswersWidget.initiateChatbot(firstStep, chatBotCallback, 'チャットサポート');

    }
);