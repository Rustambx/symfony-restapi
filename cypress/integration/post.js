describe('Post test', () => {
    beforeEach(() => {
        cy.viewport(1280, 720);
        cy.login();
    });
    it('Post index', () => {
        cy.url().should('eq', Cypress.config().baseUrl);
        cy.get('h1').should('contain', 'Hello');
        cy.get('[data-test=post]').click();
        cy.url().should('contain', '/post');
        cy.get('h1').should('contain', 'Post index');
    })

    it('Post create', () => {
        cy.visit("/post");
        cy.get('h1').should('contain', 'Post');
        cy.get('[data-test=create-new]').click();
        cy.get('h1').should('contain', 'Create new Post');
        cy.get('[data-test=title]').type("New Post");
        cy.get('[data-test=text]').type("Lorem Ipsum has been the industry's standard dummy text");

        cy.fixture('image.jpg', 'binary')
            .then(Cypress.Blob.binaryStringToBlob)
            .then(fileContent => {
                cy.get('[data-test="image"]').attachFile({
                    fileContent,
                    fileName: 'image.jpg',
                    mimeType: 'image/jpeg',
                });
            });

        cy.get('[data-test=author]').select('admin@email.com');
        cy.get('[data-test=save]').click();
        cy.url().should('contain', '/post');
    })

    it('Post show', () => {
        cy.visit("/post/1");
        cy.get('h1').should('contain', 'Post');
        cy.get('[data-test=back-list]').click();
        cy.get('h1').should('contain', 'Post index');
    })

    it('Post Edit', () => {
        cy.visit("/post/1");
        cy.get('[data-test=edit]').click();
        cy.get('h1').should('contain', 'Edit Post');
        cy.get('[data-test=title]').clear();
        cy.get('[data-test=title]').type("New Post Edit");
        cy.get('[data-test=text]').clear();
        cy.get('[data-test=text]').type("Edit Lorem Ipsum has been the industry's standard dummy text");

        cy.fixture('image.jpg', 'binary')
            .then(Cypress.Blob.binaryStringToBlob)
            .then(fileContent => {
                cy.get('[data-test="image"]').attachFile({
                    fileContent,
                    fileName: 'image.jpg',
                    mimeType: 'image/jpeg',
                });
            });

        cy.get('[data-test=author]').select('admin@email.com');
        cy.get('[data-test=save]').click();
        cy.url().should('contain', '/post');
    })
})