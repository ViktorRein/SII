document.addEventListener("DOMContentLoaded", () => {
    console.log("JavaScript подключен!");

    const clickableHeaders = document.querySelectorAll('.clickable');
    console.log("Найдено заголовков:", clickableHeaders.length);

    clickableHeaders.forEach(header => {
        header.addEventListener('click', () => {
            console.log("Клик по заголовку:", header.textContent);

            const rulesDiv = header.nextElementSibling;

            if (rulesDiv) {
                rulesDiv.classList.toggle('hidden');
                console.log("Состояние hidden:", rulesDiv.classList.contains('hidden') ? "Скрыт" : "Виден");
            } else {
                console.error("Блок правил не найден для заголовка:", header.textContent);
            }
        });
    });
});
function displayRules() {
    const rulesContainer = document.getElementById('rules-container');
    rulesContainer.innerHTML = ''; // Очистим контейнер перед добавлением новых правил

    const sections = ['admission_rules', 'student_rules', 'professor_rules'];
    
    sections.forEach(section => {
        const sectionTitle = document.createElement('h2');
        sectionTitle.innerText = capitalizeFirstLetter(section.replace('_', ' '));
        rulesContainer.appendChild(sectionTitle);

        const rulesArray = data[section];
        rulesArray.forEach(rule => {
            const ruleElement = document.createElement('div');
            ruleElement.classList.add('rule');
            ruleElement.setAttribute('data-id', rule.id);
            ruleElement.innerHTML = `
                <h3>${rule.condition}</h3>
                <p><strong>Результат:</strong> ${rule.result}</p>
                <p><strong>Описание:</strong> ${rule.description}</p>
                <button class="edit-btn" onclick="editRule(${rule.id}, '${section}')">Изменить</button>
                <button class="delete-btn" onclick="deleteRule(${rule.id}, '${section}')">Удалить</button>
            `;
            rulesContainer.appendChild(ruleElement);
        });
    });
}

function addRule() {
    const condition = document.getElementById('rule_condition').value;
    const result = document.getElementById('rule_result').value;
    const description = document.getElementById('rule_description').value;
    const ruleId = document.getElementById('rule_id').value;
    const ruleType = document.getElementById('rule_type').value;

    if (ruleId) {
        // Если редактируем, обновляем правило
        const ruleIndex = data[ruleType].findIndex(rule => rule.id === parseInt(ruleId));
        data[ruleType][ruleIndex] = { id: parseInt(ruleId), condition, result, description };
    } else {
        // Если добавляем новое правило
        const newId = data[ruleType].length > 0 ? data[ruleType][data[ruleType].length - 1].id + 1 : 1;
        const newRule = { id: newId, condition, result, description };
        data[ruleType].push(newRule);
    }

    // Сохраняем изменения в localStorage
    localStorage.setItem('rulesData', JSON.stringify(data));

    // Обновляем отображение
    displayRules();

    // Очистка формы
    document.getElementById('rule_form').reset();
    document.getElementById('add-rule-btn').innerText = 'Добавить правило';
}

// Функция для редактирования правила
function editRule(id, ruleType) {
    const rule = data[ruleType].find(rule => rule.id === id);

    document.getElementById('rule_condition').value = rule.condition;
    document.getElementById('rule_result').value = rule.result;
    document.getElementById('rule_description').value = rule.description;
    document.getElementById('rule_id').value = rule.id;
    document.getElementById('rule_type').value = ruleType;
    document.getElementById('add-rule-btn').innerText = 'Сохранить изменения';
}

// Функция для удаления правила
function deleteRule(id, ruleType) {
    const ruleIndex = data[ruleType].findIndex(rule => rule.id === id);
    if (ruleIndex !== -1) {
        data[ruleType].splice(ruleIndex, 1); // Удаляем правило
        localStorage.setItem('rulesData', JSON.stringify(data));
        displayRules(); // Перезагружаем правила
    }
}

// Функция для капитализации первой буквы
function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

// Инициализация отображения правил при загрузке страницы
displayRules();

// Слушатели для кнопок редактирования и удаления
document.getElementById('rules-container').addEventListener('click', (event) => {
    if (event.target.classList.contains('edit-btn')) {
        const ruleId = parseInt(event.target.getAttribute('data-id'));
        const ruleType = event.target.getAttribute('data-type');
        editRule(ruleId, ruleType);
    }

    if (event.target.classList.contains('delete-btn')) {
        const ruleId = parseInt(event.target.getAttribute('data-id'));
        const ruleType = event.target.getAttribute('data-type');
        deleteRule(ruleId, ruleType);
    }
});

// Обработчик формы для добавления/редактирования правила
document.getElementById('rule_form').addEventListener('submit', (event) => {
    event.preventDefault(); // Предотвратить перезагрузку страницы
    addRule();
});