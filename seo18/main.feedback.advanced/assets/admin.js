function FormFieldsList(arParams) {
    if (null != window.jsFormFieldsList) {
        try {
            window.jsFormFieldsList.Close();
        } catch (e) {}

        window.jsFormFieldsList = null;
    }

    window.jsFormFieldsList = new FormFieldsListEdit(arParams);
}

function FormFieldsListEdit(arParams) {
    var self = this;
    this.arParams = arParams;
    this.jsOptions = JSON.parse(this.arParams.data);
    this.jsOptions.types = {
        "text": "Текстовое поле",
        "checkbox": "Выбор",
        "select": "Список"
    }

    // var arElements = arParams.getElements();
    this.tableFields = BX.create('table', {
        style: { width: '100%' },
        html: '<thead><tr><td>Об.</td><td>Тип</td><td>Заголовок</td></tr></thead><tbody></tbody>'
    });
    this.arParams.oCont.appendChild( this.tableFields );

    this.getValues(arParams.oInput.value).forEach(function(val, index, array) {
        self.addFieldLine(val);
    });

    var addButton = arParams.oCont.appendChild( BX.create('button', {
        attrs: {
            id: 'applyExt',
            type: 'button'
        },
        html: 'Добавить'
    }) );

    addButton.onclick = function() {
        self.getValues().forEach(function(val, index, array) {
            self.addFieldLine(val);
        });
    }

    var obButton = arParams.oCont.appendChild( BX.create('button', {
        attrs: {
            id: 'applyExt',
            type: 'button'
        },
        html: 'Применить'
    }) );

    obButton.onclick = BX.delegate(this.__saveChanges, this);
}

FormFieldsListEdit.prototype.addFieldLine = function(val) {
    var line = BX.create('tr', {
        html: '<td></td><td></td><td></td>'
    });

    var strOptions = '';
    for (var type in this.jsOptions.types) {
        var optValue = ( type != val.type ) ? '' : ' selected';
        strOptions+= '<option value="'+type+'"'+optValue+'>'+this.jsOptions.types[type]+'</option>';
    }

    var requiredField = BX.create('input', {
        attrs: {
            'type': 'checkbox',
            'name': 'CFIELD_REQ[]',
            'class': 'CFIELD_REQ',
            'checked': ( val.req == 'Y' ) ? true : false
        }
    });

    var typeField = BX.create('select', {
        attrs: {
            'name': 'CFIELD_TYPE[]',
            'class': 'CFIELD_TYPE'
        },
        html: strOptions
    });

    var nameField = BX.create('input', {
        attrs: {
            'type': 'text',
            'name': 'CFIELD_NAME[]',
            'class': 'CFIELD_NAME',
            'value': val.name,
        },
        style: {
            width: '110px'
        }
    });

    line.getElementsByTagName('td')[0].appendChild(requiredField);
    line.getElementsByTagName('td')[1].appendChild(typeField);
    line.getElementsByTagName('td')[2].appendChild(nameField);

    this.tableFields.getElementsByTagName('tbody')[0].appendChild( line );
}

FormFieldsListEdit.prototype.getValues = function(paramVals) {
    try {
        var values = JSON.parse(paramVals);
    }
    catch(e) {
        var values = [{
            "req": '',
            "type": '',
            "name": ''
        }];
    }

    return values;
}

FormFieldsListEdit.prototype.__saveChanges = function(event) {
    event.preventDefault();

    var values = [];
    var requiredFields = this.tableFields.getElementsByClassName('CFIELD_REQ');
    var typeFields = this.tableFields.getElementsByClassName('CFIELD_TYPE');
    var nameFields = this.tableFields.getElementsByClassName('CFIELD_NAME');

    for (var i = 0; i < nameFields.length; i++) {
        if( nameFields[i].value ) {
            values.push({
              req: requiredFields[i].checked ? 'Y' : 'N',
              type: typeFields[i].value,
              name: nameFields[i].value
          });
        }
    }

    this.arParams.oInput.value = JSON.stringify(values);
}
